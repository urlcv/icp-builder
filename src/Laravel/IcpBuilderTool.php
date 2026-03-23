<?php

declare(strict_types=1);

namespace URLCV\IcpBuilder\Laravel;

use App\Tools\Contracts\ToolInterface;

class IcpBuilderTool implements ToolInterface
{
    public function slug(): string
    {
        return 'icp-builder';
    }

    public function name(): string
    {
        return 'ICP builder';
    }

    public function summary(): string
    {
        return 'Build, score, validate, and operationalise your ideal customer profile with deterministic outbound planning outputs.';
    }

    public function descriptionMd(): ?string
    {
        return <<<'MD'
## ICP builder

Define and operationalise your ideal customer profile in one browser-based workspace.

### What it includes

- Guided ICP wizard for industry, company size, geography, personas, triggers, and exclusions
- Must-have vs nice-to-have criteria with positive/negative targeting rules
- Weighted fit scoring model and account-level score calculator
- Deterministic LinkedIn/Sales Nav/Boolean query blocks
- Messaging angle matrix, 30-day outbound planner, TAM-lite estimator, and checklist
- Copyable one-pager, print-friendly brief, CSV starter schema export, and local version snapshots

Everything runs locally in your browser; no server processing required.
MD;
    }

    public function categories(): array
    {
        return ['sourcing', 'productivity'];
    }

    public function tags(): array
    {
        return ['icp', 'outbound', 'gtm', 'prospecting', 'targeting', 'sales'];
    }

    public function inputSchema(): array
    {
        return [];
    }

    public function run(array $input): array
    {
        return [];
    }

    public function mode(): string
    {
        return 'frontend';
    }

    public function isAsync(): bool
    {
        return false;
    }

    public function isPublic(): bool
    {
        return true;
    }

    public function frontendView(): ?string
    {
        return 'icp-builder::icp-builder';
    }

    public function rateLimitPerMinute(): int
    {
        return 60;
    }

    public function cacheTtlSeconds(): int
    {
        return 0;
    }

    public function sortWeight(): int
    {
        return 125;
    }
}
