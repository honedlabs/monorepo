<?php

trait CanPersistData
{
    public function isPersistent()
    {

    }
    
    public function persistSearches()
    {
        $this->persist->get('search');

        $this->persist->set('search', $this->search);

        // table

        $this->persist->set('c', $this->search);
        
    }
}