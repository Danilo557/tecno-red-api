<?php
//Usar el namespace
namespace App\Traits;

//Nombre del espacio de dominio
use Illuminate\Database\Eloquent\Builder;


trait  ApiTrait
{

    public function scopeIncluded(Builder $query)
    {
        
        if (empty($this->allowIncluded) || empty(request('included'))) {
            return;
        }
        $reation = explode(',', request('included'));
        $allowIncluded = collect( $this->allowIncluded);
        foreach ($reation as $key => $reationShip) {
           if(!$allowIncluded->contains($reationShip)){
            unset($reation[$key]);
           }
        }

        $query->with($reation);
    }
    public function  scopeFilter(Builder $query)
    {
        if (empty($this->allowFilter) || empty(request('filter'))) {
            return;
        }
        $filters = request('filter');
        $allowFilter = collect($this->allowFilter);
        foreach ($filters as $filter => $value) {
            if ($allowFilter->contains($filter)) {
                //Clausula Where
                $query->where($filter, 'LIKE', '%' . $value . '%');
            }
        }
    }

    public function scopeSort(Builder $query)
    {
        if (empty($this->allowSort) || empty(request('sort'))) {
            return;
        }
        $sortFields = explode(',', request('sort'));
        $allowSort = collect($this->allowSort);


        foreach ($sortFields as $sortField) {
            $direction = 'asc';
            if (substr($sortField, 0, 1) == '-') {
                $direction = 'desc';
                $sortField = substr($sortField, 1);
            }
            if ($allowSort->contains($sortField)) {
                $query->orderBy($sortField, $direction);
            }
        }
    }

    public function scopeGetOrPaginate(Builder $query)
    {
        if (!empty(request('perPage'))) {
            $perPage = intval(request('perPage'));
            if ($perPage) {
                return $query->paginate($perPage);
            }
        }
        return $query->get();
    }
}