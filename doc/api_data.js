define({ "api": [
  {
    "type": "get",
    "url": "/advert/",
    "title": "Get list of Advert",
    "name": "GetAdvert",
    "group": "Advert",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": [\n         {\n             \"id\": 1,\n             ...\n         },\n         {..}\n     ]\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/AdvertController.php",
    "groupTitle": "Advert"
  },
  {
    "type": "get",
    "url": "/advert/:id",
    "title": "Get detail of a Advert",
    "name": "GetAdvertDetail",
    "group": "Advert",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Advert unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/AdvertController.php",
    "groupTitle": "Advert"
  },
  {
    "type": "get",
    "url": "/album/",
    "title": "Get list of Album",
    "name": "GetAlbum",
    "group": "Album",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "singer_id",
            "description": "<p>Filter albums by singer's id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "with",
            "description": "<ul> <li>song - Return songs in album</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": [\n         {\n             \"id\": 1,\n             ...\n         },\n         {..}\n     ]\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/AlbumController.php",
    "groupTitle": "Album"
  },
  {
    "type": "get",
    "url": "/album/:id",
    "title": "Get detail of a Album",
    "name": "GetAlbumDetail",
    "group": "Album",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Album unique ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "with",
            "description": "<ul> <li>song - Return songs in album</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/AlbumController.php",
    "groupTitle": "Album"
  },
  {
    "type": "post",
    "url": "post/:post_id/comment/",
    "title": "Create new Comment",
    "name": "CreateComment",
    "group": "Comment",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "post_id",
            "description": "<p>Post that comments belong to</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "{\n    'content' : 'Comment message'\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         \"id\": 1,\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/CommentController.php",
    "groupTitle": "Comment"
  },
  {
    "type": "delete",
    "url": "/comment/:id",
    "title": "Soft-delete existing Comment",
    "name": "DeleteComment",
    "group": "Comment",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Comment unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/CommentController.php",
    "groupTitle": "Comment"
  },
  {
    "type": "get",
    "url": "post/:post_id/comment/",
    "title": "Get list of Comment",
    "name": "GetComment",
    "group": "Comment",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "post_id",
            "description": "<p>Post that comments belong to</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": [\n         {\n             \"id\": 1,\n             ...\n         },\n         {..}\n     ]\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/CommentController.php",
    "groupTitle": "Comment"
  },
  {
    "type": "get",
    "url": "/comment/:id",
    "title": "Get detail of a Comment",
    "name": "GetCommentDetail",
    "group": "Comment",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Comment unique ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "with",
            "description": "<p>Separate by &quot;,&quot; character</p> <ul> <li><code>post</code>     : Return with post info</li> <li><code>user</code>     : Return with user info</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/CommentController.php",
    "groupTitle": "Comment"
  },
  {
    "type": "put",
    "url": "/comment/:id",
    "title": "Update existing Comment",
    "name": "UpdateComment",
    "group": "Comment",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Comment unique ID.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "PUT Request-Example:",
          "content": "{\n     'post_id': 1\n     'comment': 'Comment message'\n }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/CommentController.php",
    "groupTitle": "Comment"
  },
  {
    "type": "post",
    "url": "/password/email",
    "title": "Request reset password",
    "name": "RequestResetPassword",
    "group": "ForgotPassword",
    "parameter": {
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "{\n    \"email\": \"johndoe@example.com\",\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Auth/PasswordController.php",
    "groupTitle": "ForgotPassword"
  },
  {
    "type": "post",
    "url": "/password/reset/",
    "title": "Reset password",
    "name": "ResetPassword",
    "group": "ForgotPassword",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>Reset password token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "{\n    \"token\": \"ewrrew23qqwe...\",\n    \"password\": \"strong-password\",\n    \"password_confirmation\": \"strong-password-too\",\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Auth/PasswordController.php",
    "groupTitle": "ForgotPassword"
  },
  {
    "type": "post",
    "url": "/password/verify-token/:token",
    "title": "Verify token for resetting password",
    "name": "VerifyTokenResetPassword",
    "group": "ForgotPassword",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>Reset password token</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/Auth/PasswordController.php",
    "groupTitle": "ForgotPassword"
  },
  {
    "type": "get",
    "url": "/news/detail/:id",
    "title": "Get detail of a News",
    "name": "GetDetailNews",
    "group": "News",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Get ID of News</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/NewsController.php",
    "groupTitle": "News"
  },
  {
    "type": "get",
    "url": "/news/listing/",
    "title": "Get list News",
    "name": "GetListNews",
    "group": "News",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "singer_id",
            "description": "<p>Get list news of singer.</p>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/NewsController.php",
    "groupTitle": "News"
  },
  {
    "type": "post",
    "url": "/payment/:singerId/charge",
    "title": "Create a charge",
    "name": "PaymentCharge",
    "group": "Payment",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "optional": false,
            "field": "singerId",
            "description": "<ul> <li>ID of singer</li> </ul>"
          }
        ]
      },
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "     {\n         'provider' : 'VNP | VMS | VTT | MGC',\n         'pin': '123..',\n         'serial' : '123..',\n     }\n`",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/PaymentController.php",
    "groupTitle": "Payment"
  },
  {
    "type": "get",
    "url": "/payment/:singerId/status",
    "title": "Check payment status",
    "name": "PaymentStatus",
    "group": "Payment",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "optional": false,
            "field": "singerId",
            "description": "<ul> <li>ID of singer</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         'id' => 1\n         'singer_id' => 2\n         'user_id' => 10\n         'status' => 1 //0 : Not VIP. 1: IS VIP\n         'active_date' => '2016-01-01'\n         'balance' => 50000\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/PaymentController.php",
    "groupTitle": "Payment"
  },
  {
    "type": "post",
    "url": "/payment/:singerId/subscribe",
    "title": "Become VIP",
    "name": "PaymentSubscribe",
    "group": "Payment",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "optional": false,
            "field": "singerId",
            "description": "<ul> <li>ID of singer</li> </ul>"
          }
        ]
      }
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/PaymentController.php",
    "groupTitle": "Payment"
  },
  {
    "type": "post",
    "url": "/photo/",
    "title": "Create new Photo",
    "name": "CreatePhoto",
    "group": "Photo",
    "parameter": {
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "{\n\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         \"id\": 1,\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/PhotoController.php",
    "groupTitle": "Photo"
  },
  {
    "type": "delete",
    "url": "/photo/:id",
    "title": "Delete Photo",
    "name": "DeletePhoto",
    "group": "Photo",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Photo unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/PhotoController.php",
    "groupTitle": "Photo"
  },
  {
    "type": "get",
    "url": "/photo/:id",
    "title": "Get a Photo",
    "name": "GetPhotoDetail",
    "group": "Photo",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Photo unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/PhotoController.php",
    "groupTitle": "Photo"
  },
  {
    "type": "get",
    "url": "/photo/",
    "title": "Get list of Photo",
    "name": "L_stPhoto",
    "group": "Photo",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": [\n         {\n             \"id\": 1,\n             ...\n         },\n         {..}\n     ]\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/PhotoController.php",
    "groupTitle": "Photo"
  },
  {
    "type": "put",
    "url": "/photo/:id",
    "title": "Update Photo",
    "name": "UpdatePhoto",
    "group": "Photo",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Photo unique ID.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "PUT Request-Example:",
          "content": "{\n\n }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/PhotoController.php",
    "groupTitle": "Photo"
  },
  {
    "type": "post",
    "url": "/post/",
    "title": "Create new Post",
    "name": "CreatePost",
    "group": "Post",
    "parameter": {
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "{\n    'singer_id' : 2\n    'content': 'Post content'\n    'photo' : File\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         \"id\": 1,\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/PostController.php",
    "groupTitle": "Post"
  },
  {
    "type": "delete",
    "url": "/post/:id",
    "title": "Soft-delete existing Post",
    "name": "DeletePost",
    "group": "Post",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Post unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/PostController.php",
    "groupTitle": "Post"
  },
  {
    "type": "get",
    "url": "/post/latest/:singerId",
    "title": "Get latest Post of a singer",
    "name": "GetLatestPost",
    "group": "Post",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "singerId",
            "description": "<p>Unique user ID of Singer.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "with",
            "description": "<p>Separate by &quot;,&quot; character</p> <ul> <li><code>singer</code>   : Return with singer info</li> <li><code>meta</code>     : Return with meta info of post such as Like count, Comment count..</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/PostController.php",
    "groupTitle": "Post"
  },
  {
    "type": "get",
    "url": "/post/",
    "title": "Get list of Post",
    "name": "GetPost",
    "group": "Post",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "singer_id",
            "description": "<p>Filter posts by singer's id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "with",
            "description": "<p>Separate by &quot;,&quot; character</p> <ul> <li><code>singer</code>   : Return with singer info</li> <li><code>meta</code>     : Return with meta info of post such as Like count, Comment count..</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": [\n         {\n             \"id\": 1,\n             ...\n         },\n         {..}\n     ]\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/PostController.php",
    "groupTitle": "Post"
  },
  {
    "type": "get",
    "url": "/post/:id",
    "title": "Get detail of a Post",
    "name": "GetPostDetail",
    "group": "Post",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Post unique ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "with",
            "description": "<p>Separate by &quot;,&quot; character</p> <ul> <li><code>singer</code>   : Return with singer info</li> <li><code>meta</code>     : Return with meta info of post such as Like count, Comment count..</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/PostController.php",
    "groupTitle": "Post"
  },
  {
    "type": "post",
    "url": "post/:post_id/like/",
    "title": "Like a post",
    "name": "LikePost",
    "group": "Post",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "post_id",
            "description": "<p>Post's ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         ...\n         \"likes_count\": {\n             \"post_id\": 1,\n             \"total\": 1\n         }\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/PostController.php",
    "groupTitle": "Post"
  },
  {
    "type": "post",
    "url": "post/:post_id/unlike/",
    "title": "Unlike a post",
    "name": "UnlikePost",
    "group": "Post",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "post_id",
            "description": "<p>Post's ID</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         ...\n         \"likes_count\": {\n             \"post_id\": 1,\n             \"total\": 0\n         }\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/PostController.php",
    "groupTitle": "Post"
  },
  {
    "type": "post",
    "url": "/post/:id",
    "title": "Update existing Post",
    "name": "UpdatePost",
    "group": "Post",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Post unique ID.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "{\n     'singer_id' : 2\n     'content': 'Post content'\n     'photo' : File\n }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/PostController.php",
    "groupTitle": "Post"
  },
  {
    "type": "get",
    "url": "/show/",
    "title": "Get list of Show",
    "name": "GetShow",
    "group": "Show",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "singer_id",
            "description": "<p>Filter shows by singer's id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": [\n         {\n             \"id\": 1,\n             ...\n         },\n         {..}\n     ]\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/ShowController.php",
    "groupTitle": "Show"
  },
  {
    "type": "get",
    "url": "/show/:id",
    "title": "Get detail of a Show",
    "name": "GetShowDetail",
    "group": "Show",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Show unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/ShowController.php",
    "groupTitle": "Show"
  },
  {
    "type": "get",
    "url": "/song/",
    "title": "Get list of Song",
    "name": "GetSong",
    "group": "Song",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "singer_id",
            "description": "<p>Filter songs by singer's id</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": [\n         {\n             \"id\": 1,\n             ...\n         },\n         {..}\n     ]\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/SongController.php",
    "groupTitle": "Song"
  },
  {
    "type": "get",
    "url": "/song/:id",
    "title": "Get detail of a Song",
    "name": "GetSongDetail",
    "group": "Song",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Song unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/SongController.php",
    "groupTitle": "Song"
  },
  {
    "type": "post",
    "url": "/user/",
    "title": "Create new User",
    "name": "CreateUser",
    "group": "User",
    "parameter": {
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "{\n    'name' => '',\n    'email' => 'required|email|unique,\n    'password' => 'required|min:6|max:30',\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         \"id\": 9\n         \"email\": \"fan1@example.com\",\n         \"role\": \"fan\",\n         \"updated_at\": \"2016-01-11 10:58:23\",\n         \"created_at\": \"2016-01-11 10:58:23\",\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/user/login/facebook",
    "title": "Use Facebook to Login",
    "name": "FacebookLogin",
    "group": "User",
    "parameter": {
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "{\n     \"token\" : \"5345rkf23f2332...\",\n }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         \"token\": \"435345544...\",\n         \"user\": {\n              \"id\": 9\n              \"email\": \"fan1@example.com\",\n              \"role\": \"fan\",\n              ...\n          }\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/user/:id",
    "title": "Get detail of a User",
    "name": "GetUserDetail",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>User unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         \"id\": 9\n         \"email\": \"fan1@example.com\",\n         \"role\": \"fan\",\n         ...\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/search/",
    "title": "Search some pre-defined regions",
    "name": "Search",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "keyword",
            "description": "<p>String as keyword</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "put",
    "url": "/user/:id",
    "title": "Update existing User",
    "name": "UpdateUser",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>User unique ID.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "PUT Request-Example:",
          "content": "{\n\n }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/user/authenticated",
    "title": "Get User from Token",
    "name": "UserAuthenticated",
    "group": "User",
    "version": "0.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/user/avatar",
    "title": "Upload user avatar",
    "name": "UserAvatarUpload",
    "group": "User",
    "parameter": {
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "{\n     'id' => 1\n     'avatar' => 'required|mimes:jpeg,jpg,png',\n }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         \"avatar\": \"http://...\"\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/user/change-password",
    "title": "Change Password",
    "name": "UserChangePassword",
    "group": "User",
    "parameter": {
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "{\n     \"current_password\": \"Current Password\",\n     \"new_password\" : \"New Password\",\n     \"new_password_confirmation\" : \"New Password Repeat\"\n }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/user/login",
    "title": "Login",
    "name": "UserLogin",
    "group": "User",
    "parameter": {
      "examples": [
        {
          "title": "PUT Request-Example:",
          "content": "{\n     \"email\" : \"fan1@examole.com\",\n     \"password\": \"123456\"\n }",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         \"id\": 9\n         \"email\": \"fan1@example.com\",\n         \"role\": \"fan\",\n         ...\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/user/refresh-token",
    "title": "Refresh Token",
    "name": "UserRefreshToken",
    "group": "User",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         \"token\": '1232322...\"\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/video/:id",
    "title": "Get a Video",
    "name": "GetVideoDetail",
    "group": "Video",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Video unique ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "with",
            "description": "<p>Separate by &quot;,&quot; character</p> <ul> <li><code>singer</code>   : Return with singer info</li> <li><code>song</code>     : Return with song info</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/VideoController.php",
    "groupTitle": "Video"
  },
  {
    "type": "get",
    "url": "/video/",
    "title": "Get list of Video",
    "name": "L_stVideo",
    "group": "Video",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "singer_id",
            "description": "<p>Filter videos by singer's id</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "song_id",
            "description": "<p>Filter videos by song's id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "with",
            "description": "<p>Separate by &quot;,&quot; character</p> <ul> <li><code>singer</code>   : Return with singer info</li> <li><code>song</code>     : Return with song info</li> </ul>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": [\n         {\n             \"id\": 1,\n             ...\n         },\n         {..}\n     ]\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/VideoController.php",
    "groupTitle": "Video"
  },
  {
    "type": "post",
    "url": "/website/:singer_id/setup",
    "title": "Init singer websites",
    "name": "InitWebsite",
    "group": "Website",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Singer unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": [\n         {\n             \"id\": 1,\n             ...\n         },\n         {..}\n     ]\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/WebsiteController.php",
    "groupTitle": "Website"
  },
  {
    "type": "put",
    "url": "/website/:singer_id/update",
    "title": "Update Website Content",
    "name": "UpdateWebsite",
    "group": "Website",
    "parameter": {
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "{\n    \"bio_title\" : \"Bio Title\",\n    \"bio_content\" : \"Bio Content\",\n    \"contact_title\" : \"Contact Title\",\n    \"contact_content\" : \"Contact Content\",\n    \"app_title\" : \"App Title\",\n    \"app_content\" : \"App Content\",\n    \"dev_title\" : \"Dev Title\",\n    \"dev_content\" : \"Dev Content\",\n    \"guide_title\" : \"Guide Title\",\n    \"guide_content\" : \"Guide Content\",\n}",
          "type": "json"
        }
      ]
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         \"id\": 1,\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/WebsiteController.php",
    "groupTitle": "Website"
  },
  {
    "type": "get",
    "url": "/website/:singer_id/content/:type",
    "title": "Get content",
    "name": "WebsiteBio",
    "group": "Website",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Singer unique ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>Website content type. Could be either &quot;app&quot; | &quot;bio&quot; | &quot;contact&quot; | &quot;dev&quot; | &quot;guide&quot;</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": [\n         {\n             \"id\": 1,\n             ...\n         },\n         {..}\n     ]\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/WebsiteController.php",
    "groupTitle": "Website"
  }
] });
