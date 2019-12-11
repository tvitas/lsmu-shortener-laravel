<?php
namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use App\Menu;

Trait Menuable
{
    public function getMenuTree($frontOrBack = null)
    {
        if (Cache::has('menu_tree_cache')) {
            return Cache::get('menu_tree_cache');
        }
        $menuTree = Menu::with('children', 'translations')
            ->where('parent_id', null)
            ->when($frontOrBack, function($q) use ($frontOrBack) {
                $q->where('destination', $frontOrBack);
            })->orderBy('weight', 'ASC')->get();

        Cache::put('menu_tree_cache', $menuTree, config('map.cache.ttl', 180));
        return $menuTree;
    }

    public function getMenuRoots($frontOrBack = null)
    {
        if (Cache::has('menu_roots_cache')) {
            return Cache::get('menu_roots_cache');
        }
        $menuRoots = Menu::with('translations')->where('parent_id', null)
            ->when($frontOrBack, function ($q) use ($frontOrBack) {
                $q->where('destination', $frontOrBack);
            })->orderBy('weight', 'ASC')->get();
        Cache::put('menu_roots_cache', $menuRoots, config('map.cache.ttl', 180));
        return $menuRoots;
    }

    public function getWithChildrens($parentId)
    {
        if (Cache::has('menu_with_childrens_cache')) {
            return Cache::get('menu_with_childrens_cache');
        }
        $withChildrens = Menu::with('children', 'translations')->where('parent_id', $parenId)->get();
        Cache::put('menu_with_childrens_cache', $withChildrens, config('map.cache.ttl', 180));
        return $withChildrens;
    }

    public function getWithParents($childrenId)
    {
        if (Cache::has('menu_with_parents_cache')) {
            return Cache::get('menu_with_parents_cache');
        }
        $withParents = Menu::with('parent', 'translations')->where('id', $childrenId)->get();
        Cache::put('menu_with_parents_cache', $withParents, config('map.cache.ttl', 180));
        return $withParents;
    }
}
