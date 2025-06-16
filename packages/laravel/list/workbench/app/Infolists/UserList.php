<?php

namespace Workbench\App\Infolists;

use Honed\Infolist\Entries\Entry;
use Honed\Infolist\Infolist;
use Honed\Infolist\Entries\TextEntry;
use Illuminate\Support\Facades\Auth;

class UserList extends Infolist
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