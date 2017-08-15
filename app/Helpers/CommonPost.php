<?php 
namespace App\Helpers;

use DB;

class CommonPost
{
	static function issetPostType($postId, $typeId)
	{
		$count = DB::table('post_type_relations')
			->where('post_id', $postId)
			->where('type_id', $typeId)
			->count();
		if($count > 0) {
			return true;
		}
		return false;
	}
	static function issetPostTypeChecked($postId, $typeId)
	{
		$check = self::issetPostType($postId, $typeId);
		if($check == true) {
			return 'checked="checked"';
		}
		return '';
	}
	//check type box
	static function issetMakeDisplay($postId, $makeId, $typeId, $issetCheck = true)
	{
		if($issetCheck == true) {
			$check = self::issetPostType($postId, $typeId);
			if($check == true && $makeId != $typeId) {
				return '';
			}
		} else {
			if($makeId != $typeId) {
				return '';
			}
		}
		return 'display: none;';
	}
	static function issetCheckedDisplay($makeId, $typeId)
	{
		if($makeId == $typeId) {
			return '';
		}
		return 'display: none;';
	}
	//
	static function issetPostTag($postId)
	{
		$data = DB::table('post_tag_relations')
			->where('post_id', $postId)
			->pluck('tag_id');
		if(count($data) > 0) {
			return $data;
		}
		return [];
	}
	
}