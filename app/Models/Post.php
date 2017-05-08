<?php

namespace App\Models;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * App\Models\Post
 *
 * @property integer $id
 * @property integer $content_id
 * @property string $content
 * @property string $photo
 * @property integer $staff_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class Post extends VeoModel {

    protected $table = 'master_posts';

    protected $fillable = ['id', 'master_id', 'content_id', 'content'];

    protected $hidden = [];

    protected $appends = ['is_liked', 'total_likes', 'total_comments'];

    public static function rules($key = 'create') {
        $common = [
            'content' => 'required'
        ];
        $rules = [
            'create' => array_merge($common, [
                'master_id' => 'required'
            ]),
            'update' => array_merge($common, [
            ])
        ];
        return array_get($rules, $key);
    }

    /**
     * Relationship
     */

    public function master() {
        return $this->belongsTo('App\Models\Master', 'master_id');
    }

    public function comments() {
        return $this->hasMAny('App\Models\Comment', 'post_id');
    }

    public function commentCount() {
        return $this->hasOne('App\Models\Comment')
            ->selectRaw('post_id, count(*) as total')
            ->groupBy('post_id');
    }

    public function getCommentCountAttribute() {
        // if relation is not loaded already, let's do it first
        if (!$this->relationLoaded('commentCount')) $this->load('commentCount');

        $related = $this->getRelation('commentCount');

        // then return the count directly
        return ($related) ? (int) $related->total : 0;
    }

    public function getTotalCommentsAttribute()
    {
        return $this->hasMany('App\Models\Comment', 'post_id')->count();

    }

    public function likes() {
        return $this->hasMAny('App\Models\PostLike', 'post_id');
    }

    public function likeCount() {
        return $this->hasOne('App\Models\PostLike')
            ->selectRaw('post_id, count(*) as total')
            ->groupBy('post_id');
    }

    public function getLikeCountAttribute() {
        // if relation is not loaded already, let's do it first
        if (!$this->relationLoaded('likeCount')) $this->load('likeCount');

        $related = $this->getRelation('likeCount');

        // then return the count directly
        return ($related) ? (int) $related->total : 0;
    }

    public function getTotalLikesAttribute()
    {
        return $this->hasMany('App\Models\PostLike', 'post_id')->count();

    }

    public function getIsLikedAttribute() {
        $token = JWTAuth::getToken();
        if ($token) {
            try {
                if (! $auth = JWTAuth::parseToken()->authenticate()) {
                    return false;
                }

            } catch (\Exception $e) {
                return false;
            }

            if ($auth) {
                $user = User::where('auth_id', $auth->id)->first();
                
                $liked = PostLike::where([
                    'post_id' => $this->id,
                    'user_id' => $user->id,
                ])->count();
                
                return $liked ? true : false;
            }
        }
        return false;
    }

    /**
     * Get/Set attributes
     */
    public function getPhotoAttribute() {
        return ($this->attributes['photo']) ?
            url('resources' . DS . 'uploads' . DS . $this->attributes['content_id'] . DS . 'post' . DS . $this->attributes['photo']) : '';
    }

    public function getContentAttribute() {
        $string = $this->attributes['content'];
        if ($setting = Setting::first()) {
            $filtersList = explode(PHP_EOL, trim($setting->filter));
            foreach ($filtersList as $term) {
                if (stristr($string, $term) !== false) {
                    $string = str_ireplace($term, '***', $string);
                }
            }
        }

        return $string;
    }


}
