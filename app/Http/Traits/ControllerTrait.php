<?php

namespace App\Http\Traits;

use App\Http\Traits\Mime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

trait ControllerTrait{

    protected $table;
    protected $selectable = [];
    protected $with = [];

    public function customTable($request){
        $query = count($this->selectable) ? $this->table->select($this->selectable) : $this->table->select();
        $query = count($this->with) ? $query->with($this->with) : $query;

        if ($request->trashed) {
            $query = $query->withTrashed();
        }

        if($request->filter){
            $query->where(function($query) use ($request){
                foreach ($request->filter as $key => $value) {
                    if (Schema::hasColumn($this->table->getTableName(), $key)) {
                        $query->orWhere($key,"like","%{$value}%");
                    }
                }
            });
        }

        if(count($this->whereCondition)){
            foreach ($this->whereCondition as $key => $value) {
                $cond = explode(':', $value);
                if($cond[2]){
                    $query->where($cond[0],$cond[1],$cond[2]);
                }
            }
        }

        if(count($this->whereWithCondition)){
            foreach ($this->whereWithCondition as $key => $value) {
                $cond = explode(':', $value);
                if($cond[2]){
                    $query->whereHas($key,function($q) use($cond){
                        $q->where($cond[0],$cond[1],$cond[2]);
                    });
                }
            }
        }

        if($request->sortField && $request->sortOrder){
            $query->orderBy($request->sortField,$request->sortOrder);
        }else{
            $query->orderBy('id','desc');
        }
        $totalCount = $query->count();
        if($request->pageNumber && $request->pageSize){
            $start = ($request->pageNumber - 1) * $request->pageSize;
            $start = $start < 0 ? 0 : $start;
            $query = $query->take($request->pageSize)->skip($start);
        }else{
            $start = (($request->pageNumber??1) - 1) * ($request->pageSize??10);
            $start = $start < 0 ? 0 : $start;
            $query = $query->take(($request->pageSize??10))->skip($start);
        }

        $result = new \stdClass();
        $result->totalCount = $totalCount;
        $result->items = $query->get();
        return $result;
    }

}
