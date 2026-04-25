<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class GitFlowt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gitflow:start
        {type : Branch type: feature, refactor, fix, hotfix, release, docs or chore}
        {name : Branch name without the type prefix}
        {--base= : Custom base branch}
        {--push : Push the new branch to origin after creating it}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Git Flow branch using the project branch naming convention';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $type = Str::lower($this->argument('type'));
        $name = $this->normalizeBranchName($this->argument('name'));
        $base = $this->option('base') ?: $this->baseBranchFor($type);

        if ($base === null) {
            $this->error("Invalid branch type: {$type}");
            $this->line('Available types: feature, refactor, fix, hotfix, release, docs, chore');

            return self::FAILURE;
        }

        $branch = "{$type}/{$name}";

        if ($this->branchExists($branch)) {
            $this->error("Branch already exists: {$branch}");

            return self::FAILURE;
        }

        $this->info("Starting {$branch} from {$base}");

        if (! $this->runGit(['switch', $base])) {
            return self::FAILURE;
        }

        if (! $this->runGit(['pull', 'origin', $base])) {
            return self::FAILURE;
        }

        if (! $this->runGit(['switch', '-c', $branch])) {
            return self::FAILURE;
        }

        if ($this->option('push') && ! $this->runGit(['push', '-u', 'origin', $branch])) {
            return self::FAILURE;
        }

        $this->info("Branch ready: {$branch}");

        return self::SUCCESS;
    }

    private function baseBranchFor(string $type): ?string
    {
        return match ($type) {
            'feature', 'refactor', 'fix', 'release', 'docs', 'chore' => 'develop',
            'hotfix' => 'main',
            default => null,
        };
    }

    private function normalizeBranchName(string $name): string
    {
        return Str::of($name)
            ->lower()
            ->ascii()
            ->replaceMatches('/[^a-z0-9]+/', '-')
            ->trim('-')
            ->toString();
    }

    private function branchExists(string $branch): bool
    {
        $process = new Process(['git', 'rev-parse', '--verify', $branch]);
        $process->run();

        return $process->isSuccessful();
    }

    private function runGit(array $arguments): bool
    {
        $process = new Process(['git', ...$arguments]);
        $process->setTimeout(null);
        $process->run();

        if ($process->isSuccessful()) {
            $output = trim($process->getOutput());

            if ($output !== '') {
                $this->line($output);
            }

            return true;
        }

        $this->error(trim($process->getErrorOutput()) ?: trim($process->getOutput()));

        return false;
    }
}
