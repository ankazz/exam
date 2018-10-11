<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\Resource;
class Student extends Resource
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
            'post_id' => $this->post_id,
            'job_id' => $this->job_id,
            'code' => $this->code,
            'description' => $this->description,
            'post_name' => $this->post['name'],
            'job_name' => $this->job['name'],
        ];
    }
    public function with($request) {
        return [
            'version' => '1.0.0',
            'author_url' => url('http://traversymedia.com')
        ];
    }
}