<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\Resource;
class Ttms extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'edizm_id' => $this->edizm_id,
            'tms_id' => $this->tms_id,
            'tname' => $this->tms->name,
            'ename' => $this->edizm->sname
        ];
    }
    public function with($request) {
        return [
            'version' => '1.0.0',
            'author_url' => url('http://traversymedia.com')
        ];
    }
}