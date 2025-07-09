<?php

declare(strict_types=1);

namespace Workbench\App\Batches;

use Honed\Action\Attributes\Remember;
use Honed\Action\Batch;
use Workbench\App\Models\User;

class UserProductBatch extends Batch
{
    /**
     * The user to remember.
     * 
     * @var \Workbench\App\Models\User|null
     */
    #[Remember]
    protected $user;

    /**
     * Set the user to remember.
     *
     * @return $this
     */
    public function user(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the user to remember.
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Define the batch.
     *
     * @return $this
     */
    protected function definition(): static
    {
        return $this;
    }
}
