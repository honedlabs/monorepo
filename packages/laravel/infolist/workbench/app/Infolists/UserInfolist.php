<?php

declare(strict_types=1);

namespace Workbench\App\Infolists;

use Honed\Infolist\Entries\DateTimeEntry;
use Honed\Infolist\Entries\Entry;
use Honed\Infolist\Entries\TextEntry;
use Honed\Infolist\Infolist;
use Illuminate\Support\Facades\Auth;

class UserInfolist extends Infolist
{
    /**
     * Define the list.
     *
     * @return $this
     */
    protected function definition(): static
    {
        return $this
            ->entries([
                TextEntry::make('name'),

                Entry::make('email', 'Email address')
                    ->allow(fn () => Auth::id() > 1),

                DateTimeEntry::make('created_at')
                    ->label('Account made')
                    ->timezone('Australia/Brisbane'),
            ]);
    }
}
