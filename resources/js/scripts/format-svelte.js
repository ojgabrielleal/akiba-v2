import { readdir, readFile, writeFile } from 'node:fs/promises';
import path from 'node:path';
import process from 'node:process';

const projectRoot = process.cwd();
const svelteRoot = path.join(projectRoot, 'resources', 'js');

async function findSvelteFiles(directory) {
    const entries = await readdir(directory, { withFileTypes: true });
    const files = [];

    for (const entry of entries) {
        const fullPath = path.join(directory, entry.name);

        if (entry.isDirectory()) {
            files.push(...await findSvelteFiles(fullPath));
            continue;
        }

        if (entry.isFile() && entry.name.endsWith('.svelte')) {
            files.push(fullPath);
        }
    }

    return files;
}

function getAttributes(attributes) {
    const normalized = attributes.trim();
    const parsed = [];
    let current = '';
    let quote = null;
    let braceDepth = 0;

    for (const character of normalized) {
        if (quote) {
            current += character;

            if (character === quote) {
                quote = null;
            }

            continue;
        }

        if (character === '"' || character === "'" || character === '`') {
            quote = character;
            current += character;
            continue;
        }

        if (character === '{') {
            braceDepth += 1;
            current += character;
            continue;
        }

        if (character === '}') {
            braceDepth -= 1;
            current += character;
            continue;
        }

        if (/\s/.test(character) && braceDepth === 0) {
            if (current) {
                parsed.push(current);
                current = '';
            }

            continue;
        }

        current += character;
    }

    if (current) {
        parsed.push(current);
    }

    return parsed;
}

function repairSplitBracedAttributes(source) {
    const lines = source.split(/\r?\n/);

    for (let index = 1; index < lines.length; index += 1) {
        if (lines[index].trim() !== '}') {
            continue;
        }

        const openingBraces = (lines[index - 1].match(/\{/g) ?? []).length;
        const closingBraces = (lines[index - 1].match(/\}/g) ?? []).length;

        if (openingBraces > closingBraces) {
            lines[index - 1] = `${lines[index - 1]}}`;
            lines.splice(index, 1);
            index -= 1;
        }
    }

    return lines.join('\n');
}

function findClassArrayEnd(source, start) {
    let quote = null;
    let braceDepth = 1;
    let bracketDepth = 1;

    for (let index = start; index < source.length; index += 1) {
        const character = source[index];

        if (quote) {
            if (character === quote && source[index - 1] !== '\\') {
                quote = null;
            }

            continue;
        }

        if (character === '"' || character === "'" || character === '`') {
            quote = character;
            continue;
        }

        if (character === '{') {
            braceDepth += 1;
            continue;
        }

        if (character === '}') {
            braceDepth -= 1;

            if (braceDepth === 0 && bracketDepth === 0) {
                return index;
            }

            continue;
        }

        if (character === '[') {
            bracketDepth += 1;
            continue;
        }

        if (character === ']') {
            bracketDepth -= 1;
        }
    }

    return -1;
}

function splitTopLevelItems(source) {
    const items = [];
    let current = '';
    let quote = null;
    let braceDepth = 0;
    let bracketDepth = 0;

    for (const character of source) {
        if (quote) {
            current += character;

            if (character === quote) {
                quote = null;
            }

            continue;
        }

        if (character === '"' || character === "'" || character === '`') {
            quote = character;
            current += character;
            continue;
        }

        if (character === '{') {
            braceDepth += 1;
        }

        if (character === '}') {
            braceDepth -= 1;
        }

        if (character === '[') {
            bracketDepth += 1;
        }

        if (character === ']') {
            bracketDepth -= 1;
        }

        if (character === ',' && braceDepth === 0 && bracketDepth === 0) {
            if (current.trim()) {
                items.push(current.trim());
            }

            current = '';
            continue;
        }

        current += character;
    }

    if (current.trim()) {
        items.push(current.trim());
    }

    return items;
}

function normalizeClassCondition(condition) {
    const compact = condition.replace(/\s+/g, ' ').trim();
    const notEqualMatch = compact.match(/^(.+?)\s+!\s+(.+)$/);

    if (notEqualMatch) {
        const rightSide = ['light', 'akiba', 'night'].includes(notEqualMatch[2])
            ? `"${notEqualMatch[2]}"`
            : notEqualMatch[2];

        return `${notEqualMatch[1]} !== ${rightSide}`;
    }

    return compact;
}

function normalizeClassArrayItem(item) {
    const trimmed = item.replace(/,$/, '').trim();

    if (!trimmed.startsWith('{') || !trimmed.endsWith('}')) {
        return trimmed;
    }

    const content = trimmed.slice(1, -1).trim().replace(/,$/, '').trim();
    const colonIndex = content.indexOf(':');

    if (colonIndex === -1) {
        return trimmed;
    }

    const className = content.slice(0, colonIndex).trim().replace(/^["']|["']$/g, '').replace(/\s+/g, ' ');
    const condition = normalizeClassCondition(content.slice(colonIndex + 1));

    return `{ "${className}": ${condition} }`;
}

function sortAttributes(attributes, tag = null) {
    const priority = (attribute) => {
        if (tag === 'label' && attribute.startsWith('for=')) {
            return 10;
        }

        if (tag === 'label' && attribute.startsWith('class=')) {
            return 20;
        }

        if (['input', 'select', 'textarea'].includes(tag) && attribute === 'required') {
            return 90;
        }

        if (attribute.startsWith('on:')) {
            return 100;
        }

        return 50;
    };

    return attributes
        .map((attribute, index) => ({ attribute, index }))
        .sort((left, right) => priority(left.attribute) - priority(right.attribute) || left.index - right.index)
        .map(({ attribute }) => attribute);
}

function normalizeClassArrays(source) {
    let formatted = '';
    let cursor = 0;

    while (cursor < source.length) {
        const start = source.indexOf('class={[', cursor);

        if (start === -1) {
            formatted += source.slice(cursor);
            break;
        }

        const end = findClassArrayEnd(source, start + 'class={['.length);

        if (end === -1) {
            formatted += source.slice(cursor);
            break;
        }

        const lineStart = source.lastIndexOf('\n', start) + 1;
        const indent = source.slice(lineStart, start).match(/^\s*/)[0];
        const itemIndent = `${indent}    `;
        const content = source.slice(start + 'class={['.length, end - 1);
        const items = splitTopLevelItems(content).map(normalizeClassArrayItem);
        const [firstItem, ...remainingItems] = items;

        formatted += source.slice(cursor, start);
        formatted += [
            `class={[${firstItem},`,
            ...remainingItems.map((item) => `${itemIndent}${item},`),
            `${indent}]}`,
        ].join('\n');
        cursor = end + 1;
    }

    return formatted;
}

function formatOpeningTag(indent, tag, rawAttributes, selfClosing) {
    let attributes = sortAttributes(getAttributes(rawAttributes), tag);

    if (attributes.length === 0) {
        return null;
    }

    if (tag === 'img') {
        attributes = attributes.filter((attribute) => !attribute.startsWith('title='));
        const altAttribute = attributes.find((attribute) => attribute.startsWith('alt='));

        if (altAttribute && !/^alt=(?:""|'')$/.test(altAttribute)) {
            attributes = attributes.filter((attribute) => !attribute.startsWith('aria-hidden='));
        } else if (!altAttribute) {
            attributes = attributes.toSpliced(1, 0, 'alt=""', 'aria-hidden="true"');
        } else if (!attributes.some((attribute) => attribute.startsWith('aria-hidden='))) {
            attributes = attributes.toSpliced(attributes.indexOf(altAttribute) + 1, 0, 'aria-hidden="true"');
        }

        return [
            `${indent}<${tag}`,
            ...attributes.map((attribute) => `${indent}    ${attribute}`),
            `${indent}${selfClosing ? '/>' : '>'}`,
        ].join('\n');
    }

    if (['input', 'select', 'textarea'].includes(tag)) {
        return [
            `${indent}<${tag}`,
            ...attributes.map((attribute) => `${indent}    ${attribute}`),
            `${indent}${selfClosing ? '/>' : '>'}`,
        ].join('\n');
    }

    if (['Link', 'a'].includes(tag) || attributes.length < 3) {
        return `${indent}<${tag} ${attributes.join(' ')}${selfClosing ? ' /' : ''}>`;
    }

    return [
        `${indent}<${tag}`,
        ...attributes.map((attribute) => `${indent}    ${attribute}`),
        `${indent}${selfClosing ? '/>' : '>'}`,
    ].join('\n');
}

function formatOpeningTags(source) {
    const lines = source.split(/\r?\n/);
    const formatted = [];

    for (let index = 0; index < lines.length; index += 1) {
        const multilineMatch = lines[index].match(/^([^\S\r\n]*)<([A-Za-z][A-Za-z0-9:-]*)$/);

        if (multilineMatch) {
            const [, indent, tag] = multilineMatch;
            const attributeLines = [];
            let cursor = index + 1;
            let closingMatch = null;

            while (cursor < lines.length) {
                closingMatch = lines[cursor].match(new RegExp(`^${indent}(\\/?)>$`));

                if (closingMatch) {
                    break;
                }

                if (!lines[cursor].startsWith(`${indent}    `)) {
                    closingMatch = null;
                    break;
                }

                attributeLines.push(lines[cursor].trim());
                cursor += 1;
            }

            if (closingMatch) {
                formatted.push(formatOpeningTag(indent, tag, attributeLines.join(' '), closingMatch[1]) ?? lines[index]);
                index = cursor;
                continue;
            }
        }

        formatted.push(lines[index].replace(
            /^([^\S\r\n]*)<([A-Za-z][A-Za-z0-9:-]*)((?:\s+[^<>]*?)?)\s*(\/?)>[^\S\r\n]*$/,
            (line, indent, tag, rawAttributes, selfClosing) => {
                return formatOpeningTag(indent, tag, rawAttributes, selfClosing) ?? line;
            },
        ));
    }

    return formatInlineClassOpeningTags(formatted.join('\n'));
}

function formatInlineClassOpeningTags(source) {
    const lines = source.split(/\r?\n/);
    const formatted = [];

    for (let index = 0; index < lines.length; index += 1) {
        const match = lines[index].match(/^([^\S\r\n]*)<([A-Za-z][A-Za-z0-9:-]*)([\s\S]*class=\{\[[\s\S]*)$/);

        if (!match || lines[index].includes(']}>')) {
            formatted.push(lines[index]);
            continue;
        }

        const [, indent, tag] = match;
        const block = [lines[index]];
        let cursor = index + 1;
        let foundEnd = false;

        while (cursor < lines.length) {
            block.push(lines[cursor]);

            if (lines[cursor].trim().endsWith(']}>')) {
                foundEnd = true;
                break;
            }

            cursor += 1;
        }

        if (!foundEnd) {
            formatted.push(lines[index]);
            continue;
        }

        const opening = block.join('\n');
        const rawAttributes = opening
            .replace(new RegExp(`^${indent}<${tag}\\s*`), '')
            .replace(/>$/, '');

        formatted.push(formatOpeningTag(indent, tag, rawAttributes, ''));
        index = cursor;
    }

    return formatted.join('\n');
}

function findOpeningTagEnd(line, start) {
    let quote = null;
    let braceDepth = 0;

    for (let index = start; index < line.length; index += 1) {
        const character = line[index];

        if (quote) {
            if (character === quote && line[index - 1] !== '\\') {
                quote = null;
            }

            continue;
        }

        if (character === '"' || character === "'" || character === '`') {
            quote = character;
            continue;
        }

        if (character === '{') {
            braceDepth += 1;
            continue;
        }

        if (character === '}') {
            braceDepth -= 1;
            continue;
        }

        if (character === '>' && braceDepth === 0) {
            return index;
        }
    }

    return -1;
}

function formatInlineOpeningTags(source) {
    return source.split(/\r?\n/).map((line) => {
        const match = line.match(/^([^\S\r\n]*)<([A-Za-z][A-Za-z0-9:-]*)\s/);

        if (!match) {
            return line;
        }

        const [, indent, tag] = match;
        const tagStart = indent.length;
        const tagEnd = findOpeningTagEnd(line, tagStart);

        if (tagEnd === -1) {
            return line;
        }

        const opening = line.slice(tagStart, tagEnd + 1);
        const openingMatch = opening.match(/^<([A-Za-z][A-Za-z0-9:-]*)([\s\S]*?)(\/?)>$/);

        if (!openingMatch) {
            return line;
        }

        const formatted = formatOpeningTag(indent, tag, openingMatch[2], openingMatch[3]);

        if (!formatted || formatted.includes('\n')) {
            return line;
        }

        return `${formatted}${line.slice(tagEnd + 1)}`;
    }).join('\n');
}

function formatEmptyFormTags(source) {
    return source.replace(
        /^([^\S\r\n]*)<(input|select|textarea)\s+([^>\r\n]*)><\/\2>[^\S\r\n]*$/gm,
        (line, indent, tag, rawAttributes) => {
            return [
                formatOpeningTag(indent, tag, rawAttributes, ''),
                `${indent}</${tag}>`,
            ].join('\n');
        },
    );
}

function formatEmptyElementTags(source) {
    const excludedTags = ['img', 'input', 'select', 'textarea'];
    const lines = source.split(/\r?\n/);
    const formatted = [];

    for (let index = 0; index < lines.length; index += 1) {
        const openingMatch = lines[index].match(/^([^\S\r\n]*)<([A-Za-z][A-Za-z0-9:-]*)$/);

        if (!openingMatch) {
            formatted.push(lines[index]);
            continue;
        }

        const [, indent, tag] = openingMatch;

        if (excludedTags.includes(tag)) {
            formatted.push(lines[index]);
            continue;
        }

        const attributeLines = [];
        let cursor = index + 1;

        while (cursor < lines.length && lines[cursor].startsWith(`${indent}    `)) {
            attributeLines.push(lines[cursor].trim());
            cursor += 1;
        }

        if (attributeLines.length > 0 && lines[cursor] === `${indent}></${tag}>`) {
            const attributes = sortAttributes(getAttributes(attributeLines.join(' ')), tag);
            formatted.push(`${indent}<${tag} ${attributes.join(' ')}></${tag}>`);
            index = cursor;
            continue;
        }

        formatted.push(lines[index]);
    }

    return formatted.join('\n');
}

function hasVisibleText(content) {
    return content
        .replace(/<[^>]+>/g, '')
        .replace(/\{#[\s\S]*?\}/g, '')
        .replace(/\{\/[\s\S]*?\}/g, '')
        .replace(/\{:[\s\S]*?\}/g, '')
        .replace(/\{[\s\S]*?\}/g, '')
        .trim().length > 0;
}

function addMissingButtonLabels(source) {
    return source.replace(
        /<button\b([^>]*)>([\s\S]*?)<\/button>/g,
        (button, attributes, content) => {
            if (/\saria-label=/.test(attributes) || hasVisibleText(content)) {
                return button;
            }

            return button.replace('<button', '<button aria-label=""');
        },
    );
}

function formatSvelte(source) {
    return formatEmptyElementTags(formatEmptyFormTags(formatInlineOpeningTags(formatOpeningTags(addMissingButtonLabels(formatOpeningTags(normalizeClassArrays(repairSplitBracedAttributes(source)))))))).replace(
        /^([^\S\r\n]*)<([A-Za-z][A-Za-z0-9:-]*)([^>]*)>([^\S\r\n]*\S(?:[^\r\n]*\S)?[^\S\r\n]*)<\/\2>[^\S\r\n]*\r?$/gm,
        (line, indent, tag, attributes, content) => {
            const childIndent = `${indent}    `;

            return [
                `${indent}<${tag}${attributes}>`,
                `${childIndent}${content.trim()}`,
                `${indent}</${tag}>`,
            ].join('\n');
        },
    );
}

async function formatFile(filePath) {
    const source = await readFile(filePath, 'utf8');
    const formatted = formatSvelte(source);

    if (formatted === source) {
        return false;
    }

    await writeFile(filePath, formatted);

    return true;
}

const files = await findSvelteFiles(svelteRoot);
let changed = 0;

for (const file of files) {
    if (await formatFile(file)) {
        changed += 1;
    }
}

console.log(`Svelte formatter checked ${files.length} files and changed ${changed}.`);
