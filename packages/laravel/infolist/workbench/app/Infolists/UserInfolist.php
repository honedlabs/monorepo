<?php

declare(strict_types=1);

namespace Workbench\App\Infolists;

use Honed\Infolist\Entries\Entry;
use Honed\Infolist\Entries\TextEntry;
use Honed\Infolist\Infolist;
use Illuminate\Support\Facades\Auth;

class UserInfolist extends Infolist
{
    /**
     * Define the list.
     *
     * @param  $this  $list
     * @return $this
     */
    public function definition(Infolist $list): Infolist
    {
        return $list
            ->entries([
                TextEntry::make('name'),

                Entry::make('email', 'Email address')
                    ->allow(fn () => Auth::id() > 1),

                Entry::make('created_at')
                    ->label('Account made')
                    ->dateTime()
                    ->timezone('Australia/Brisbane'),
            ]);
    }
}
