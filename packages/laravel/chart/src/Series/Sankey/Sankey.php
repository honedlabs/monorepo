<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Sankey;

use Honed\Chart\Enums\ChartType;
use Honed\Chart\Series\Series;

class Sankey extends Series
{
    /**
     * Provide the series with any necessary setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->type(ChartType::Sankey);
    }

    /**
     * Get the array representation of the heatmap series.
     *
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            // 'type',
            // 'id' => $this->getId(),
            // 'name' => $this->getName(),
            // 'zLevel',
            // 'z',
            // 'left',
            // 'top',
            // 'right',
            // 'bottom',
            // 'width',
            // 'height',
            // 'nodeWidth',
            // 'nodeGap',
            // 'nodeAlign',
            // 'layoutIterations',
            // 'orient',
            // 'draggable',
            // 'edgeLabel',
            // 'levels',
            // 'label',
            // 'labelLayout',
            // 'itemStyle',
            // 'lineStyle',
            // 'emphasis',
            // 'blur',
            // 'select',
            // 'selectedMdode',
            // 'data', // nodes
            // 'links',
            // 'edges',
            // 'silent',
            // '...animation'
            // 'tooltip',
        ];
    }
}
