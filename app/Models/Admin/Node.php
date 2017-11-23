<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    public function formatMenu($menus)
    {
        $data = [];
        foreach ($menus as $v) {
            if ($v->depth == 1) {
                $data[$v->id] = $v;
            }
        }
        //使sort_factor起作用,分两次循环(仅用code排序时,循环一次就够了)
        foreach ($menus as $v) {
            if ($v->depth == 2) {
                $data[$v->pid]->children[] = $v;
            }
        }
        return array_values($data);
    }

    public function getFormatMenu()
    {
        $menus = json_decode(json_encode($this->getMenu()));
        return $this->formatMenu($menus);
    }

    public function getMenu()
    {
        return  $this->where([
                    ['type', '0'],
                    ['status', '0'],
                ])->orderBy('sort_factor')->get();
    }
}
