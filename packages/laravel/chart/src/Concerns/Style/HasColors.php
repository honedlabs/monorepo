<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Style;

use Honed\Chart\Style\Gradient;
use Honed\Chart\Style\Rgb;
use Honed\Chart\Style\Rgba;
use Honed\Chart\Support\Color;
use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;

trait HasColors
{
    /**
     * The colors.
     *
     * @var Collection<int, string|Rgb|Rgba|Gradient>|null
     */
    protected $colors;

    /**
     * Add a color to the palette.
     *
     * @return $this
     */
    public function color(string|Rgb|Rgba|Gradient $value): static
    {
        $this->colors = $this->getColors()->push($value);

        return $this;
    }

    /**
     * Add a colour to the palette.
     *
     * @return $this
     */
    public function colour(string|Rgb|Rgba|Gradient $value): static
    {
        return $this->color($value);
    }

    /**
     * Merge colors into the palette.
     *
     * @param  string|Rgb|Rgba|Gradient|Enumerable<int, string|Rgb|Rgba|Gradient>|list<string|Rgb|Rgba|Gradient>  $colors
     * @return $this
     */
    public function colors(string|Rgb|Rgba|Gradient|Enumerable|array $colors): static
    {
        if ($colors instanceof Enumerable || is_array($colors)) {
            $this->colors = $this->getColors()->merge(
                $colors instanceof Enumerable ? $colors->all() : $colors
            );

            return $this;
        }

        return $this->color($colors);
    }

    /**
     * Merge colours into the palette.
     *
     * @param  string|Rgb|Rgba|Gradient|Enumerable<int, string|Rgb|Rgba|Gradient>|list<string|Rgb|Rgba|Gradient>  $colours
     * @return $this
     */
    public function colours(string|Rgb|Rgba|Gradient|Enumerable|array $colours): static
    {
        return $this->colors($colours);
    }

    /**
     * Get the colors.
     *
     * @return Collection<int, string|Rgb|Rgba|Gradient>
     */
    public function getColors(): Collection
    {
        return $this->colors ??= new Collection();
    }

    /**
     * Determine if the chart has colors in the palette.
     */
    public function hasColors(): bool
    {
        return $this->getColors()->isNotEmpty();
    }

    /**
     * Get the list of colors for the chart representation.
     *
     * @return list<string|array<string, mixed>>
     */
    public function listColors(): array
    {
        return array_values(
            array_filter(
                array_map(
                    static fn (string|Rgb|Rgba|Gradient $color) => Color::from($color),
                    $this->getColors()->all()
                )
            )
        );
    }
}
