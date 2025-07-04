<?php

declare(strict_types=1);

namespace Honed\Stat\Concerns;

use Honed\Stat\Profile;
use Honed\Stat\Stat;

/**
 * @phpstan-require-extends \Honed\Stat\Contracts\Profilable
 */
trait HasProfile
{
    /**
     * The profile.
     *
     * @var Profile|null
     */
    protected $stats;

    /**
     * Set a profile to use for the stats.
     */
    public function profile(Profile $profile): static
    {
        $this->stats = $profile;

        return $this;
    }

    /**
     * Set stats to use for the profile.
     */
    public function stats(array|Stat $stats): static
    {
        /** @var array<int,Stat> */
        $stats = is_array($stats) ? $stats : func_get_args();

        $this->getProfile()->stats($stats);

        return $this;
    }

    /**
     * Get the profile.
     */
    public function getProfile(): Profile
    {
        return $this->newProfile();
    }

    /**
     * Get the profile as an array for spreading.
     *
     * @return array<string,mixed>
     */
    public function profiler(): array
    {
        return $this->getProfile()->toArray();
    }

    /**
     * Get a profile instance, or create one if it isn't set.
     */
    protected function newProfile()
    {
        return $this->profile ??= Profile::make();
    }
}
