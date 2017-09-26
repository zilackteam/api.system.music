define({ "api": [
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
            "field": "content_id",
            "description": "<p>Filter albums by content id</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "is_public",
            "description": "<p>If is_public = 1, get data public only</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "limit",
            "description": "<p>Number of record</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "page",
            "description": "<p>Number of page</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "columns",
            "description": "<p>List columns data. Eg: id,name</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "includes",
            "description": "<ul> <li>songs - Return songs in album</li> </ul>"
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
    "version": "1.0.0",
    "filename": "app/Http/Controllers/AlbumController.php",
    "groupTitle": "Album"
  },
  {
    "type": "get",
    "url": "/album/:id",
    "title": "Get detail of Album",
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
            "description": "<p>Album unique ID</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "includes",
            "description": "<ul> <li>songs - Return songs in album</li> </ul>"
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
    "version": "1.0.0",
    "filename": "app/Http/Controllers/AlbumController.php",
    "groupTitle": "Album"
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
            "field": "content_id",
            "description": "<p>Filter songs by content id</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "is_public",
            "description": "<p>If is_public = 1, get data public only</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "limit",
            "description": "<p>Number of record</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "page",
            "description": "<p>Number of page</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "columns",
            "description": "<p>List columns data. Eg: id,name</p>"
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
    "version": "1.0.0",
    "filename": "app/Http/Controllers/SongController.php",
    "groupTitle": "Song"
  },
  {
    "type": "get",
    "url": "/song/:id",
    "title": "Get detail of Song",
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
            "description": "<p>Song unique ID</p>"
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
    "version": "1.0.0",
    "filename": "app/Http/Controllers/SongController.php",
    "groupTitle": "Song"
  },
  {
    "type": "get",
    "url": "/video/",
    "title": "Get list of Video",
    "name": "GetVideo",
    "group": "Video",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "content_id",
            "description": "<p>Filter videos by content id</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "is_public",
            "description": "<p>If is_public = 1, get data public only</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "limit",
            "description": "<p>Number of record</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "page",
            "description": "<p>Number of page</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "columns",
            "description": "<p>List columns data. Eg: id,name</p>"
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
    "version": "1.0.0",
    "filename": "app/Http/Controllers/VideoController.php",
    "groupTitle": "Video"
  },
  {
    "type": "get",
    "url": "/video/:id",
    "title": "Get detail of Video",
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
            "description": "<p>Video unique ID</p>"
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
    "version": "1.0.0",
    "filename": "app/Http/Controllers/VideoController.php",
    "groupTitle": "Video"
  },
  {
    "type": "get",
    "url": "/news/",
    "title": "Get list of News",
    "name": "GetNews",
    "group": "News",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "content_id",
            "description": "<p>Filter news by content id</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "limit",
            "description": "<p>Number of record</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "page",
            "description": "<p>Number of page</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "columns",
            "description": "<p>List columns data. Eg: id,name</p>"
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
    "version": "1.0.0",
    "filename": "app/Http/Controllers/NewsController.php",
    "groupTitle": "News"
  },
  {
    "type": "get",
    "url": "/news/:id",
    "title": "Get detail of News",
    "name": "GetNewsDetail",
    "group": "News",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>News unique ID</p>"
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
    "version": "1.0.0",
    "filename": "app/Http/Controllers/NewsController.php",
    "groupTitle": "News"
  },
  {
    "type": "get",
    "url": "/news/detail/:id",
    "title": "Get detail of News (HTML)",
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
    "version": "1.0.0",
    "filename": "app/Http/Controllers/NewsController.php",
    "groupTitle": "News"
  },
  {
    "type": "get",
    "url": "/news/listing/",
    "title": "Get list of News (HTML)",
    "name": "GetListNews",
    "group": "News",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "content_id",
            "description": "<p>Get list news of content_id.</p>"
          }
        ]
      }
    },
    "version": "1.0.0",
    "filename": "app/Http/Controllers/NewsController.php",
    "groupTitle": "News"
  },
  {
    "type": "get",
    "url": "/photo/",
    "title": "Get list of Photo",
    "name": "GetPhoto",
    "group": "Photo",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "content_id",
            "description": "<p>Filter photo by content id</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "page",
            "description": "<p>Number of page</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "limit",
            "description": "<p>Number of record</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "columns",
            "description": "<p>List columns data. Eg: id,name</p>"
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
    "version": "1.0.0",
    "filename": "app/Http/Controllers/PhotoController.php",
    "groupTitle": "Photo"
  },
  {
    "type": "get",
    "url": "/photo/:id",
    "title": "Get detail of Photo",
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
            "description": "<p>Photo unique ID</p>"
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
    "version": "1.0.0",
    "filename": "app/Http/Controllers/PhotoController.php",
    "groupTitle": "Photo"
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
            "field": "content_id",
            "description": "<p>Filter show by content id</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "page",
            "description": "<p>Number of page</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "limit",
            "description": "<p>Number of record</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "columns",
            "description": "<p>List columns data. Eg: id,name</p>"
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
    "version": "1.0.0",
    "filename": "app/Http/Controllers/ShowController.php",
    "groupTitle": "Show"
  },
  {
    "type": "get",
    "url": "/show/:id",
    "title": "Get detail of Show",
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
            "description": "<p>Show unique ID</p>"
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
    "version": "1.0.0",
    "filename": "app/Http/Controllers/ShowController.php",
    "groupTitle": "Show"
  },
  {
    "type": "get",
    "url": "/version/",
    "title": "Get latest version",
    "name": "GetVersion",
    "group": "Version",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "bundle_id",
            "description": "<p>Bundle id. Eg: com.zilack.music.thuphuong</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "platform",
            "description": "<p>Platform. Eg: ios, android</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         \"content_id\": 1,\n         \"version\": 1.0.1,\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "1.0.0",
    "filename": "app/Http/Controllers/VersionController.php",
    "groupTitle": "Version"
  },
  {
    "type": "get",
    "url": "/search/",
    "title": "Search data",
    "name": "GetSearch",
    "group": "Search",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "content_id",
            "description": "<p>Search song, album, video by content id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "keyword",
            "description": "<p>Keyword search</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         \"albums\": {...},\n         \"songs\": {...},\n         \"videos\": {...}\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "1.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "Search"
  },
  {
    "type": "post",
    "url": "/auth/login",
    "title": "Login",
    "name": "PostLogin",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sec_name",
            "description": "<p>Login name is email or phone ...</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sec_pass",
            "description": "<p>Login password</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIU...\",\n         \"auth\": {...}\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "1.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/auth/avatar",
    "title": "Avatar",
    "name": "PostAvatar",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Auth id from login</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "avatar",
            "description": "<p>File avatar upload</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         \"avatar\": \"http://...\",\n         \n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "1.0.0",
    "filename": "app/Http/Controllers/AuthController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/auth/change-password",
    "title": "Change Password",
    "name": "AuthChangePassword",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "current_password",
            "description": "<p>Current Password</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "new_password",
            "description": "<p>New Password</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "new_password_confirmation",
            "description": "<p>New Password Repeat</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         \"avatar\": \"http://...\",\n         \n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "1.0.0",
    "filename": "app/Http/Controllers/AuthController.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/suggestion/",
    "title": "Suggestion",
    "name": "GetSuggestion",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [

        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": [\n         {\n              \"name\": \"Anh yêu em\",\n              \"tag\": \"Anh yeu em\"\n         },\n         ...\n     ]\n }",
          "type": "json"
        }
      ]
    },
    "version": "1.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "post",
    "url": "/user/",
    "title": "Create user",
    "name": "PostUser",
    "group": "User",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sec_name",
            "description": "<p>Login name is email or phone ...</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sec_pass",
            "description": "<p>Login password</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Name</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "type",
            "description": "<p>Type of login. <ul><li>1 : Facebook</li><li>2: Email</li><li>3: Phone</li></ul></p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": "<p>Phone number</p>"
          },
          {
            "group": "Parameter",
            "type": "Date",
            "optional": false,
            "field": "dob",
            "description": "<p>Date of birth</p>"
          },
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n         \"sec_name\": \"example@gmail.com\",\n         \"type\": \"2\"\n     }\n }",
          "type": "json"
        }
      ]
    },
    "version": "1.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "User"
  },
  {
    "type": "get",
    "url": "/category/",
    "title": "Get list of Cagegory",
    "name": "GetCategory",
    "group": "Category",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "type",
            "description": "<p>Type of category<ul><li>1 : Photo</li><li>2: Video</li></ul></p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": [\n         {\n             \"id\": 1,\n             \"name\": \"Ảnh tư liệu\",\n             ...\n         },\n         {..}\n     ]\n }",
          "type": "json"
        }
      ]
    },
    "version": "1.0.0",
    "filename": "app/Http/Controllers/CategoryController.php",
    "groupTitle": "Category"
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
          "content": "{\n    'content_id' : 3\n    'content': 'Post content'\n    'photo' : File\n}",
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
    "version": "1.0.0",
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
    "version": "1.0.0",
    "filename": "app/Http/Controllers/PostController.php",
    "groupTitle": "Post"
  },
  {
    "type": "get",
    "url": "/post/latest/:content_id",
    "title": "Get latest Post of a app",
    "name": "GetLatestPost",
    "group": "Post",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "content_id",
            "description": "<p>Unique user ID of Singer.</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "includes",
            "description": "<p>Includes: <ul>comments</li><li>master</li></ul></p>"
          },
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
    "version": "1.0.0",
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
            "field": "content_id",
            "description": "<p>Filter posts by content_id</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "includes",
            "description": "<p>Includes: <ul><li>comments</li></ul></p>"
          },
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
    "version": "1.0.0",
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
            "type": "Integer",
            "optional": false,
            "field": "includes",
            "description": "<p>Includes: <ul><li>comments</li></ul></p>"
          },
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
    "version": "1.0.0",
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
    "version": "1.0.0",
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
    "version": "1.0.0",
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
          "content": "{\n     'id' : 2\n     'content': 'Post content'\n     'photo' : File\n }",
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
    "version": "1.0.0",
    "filename": "app/Http/Controllers/PostController.php",
    "groupTitle": "Post"
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
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>Post that comments</p>"
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
    "version": "1.0.0",
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
    "version": "1.0.0",
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
    "version": "1.0.0",
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
    "version": "1.0.0",
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
          "content": "{\n     'post_id': 1\n     'content': 'Comment message'\n }",
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
    "version": "1.0.0",
    "filename": "app/Http/Controllers/CommentController.php",
    "groupTitle": "Comment"
  },
  {
    "type": "post",
    "url": "device/",
    "title": "Add new device token",
    "name": "CreateDevice",
    "group": "Device",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "app_id",
            "description": "<p>Post that app id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "device_token",
            "description": "<p>Post that device token</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "platform",
            "description": "<p>Platform: ex: ios, android</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "{\n    'app_id' : '1'\n}",
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
    "version": "1.0.0",
    "filename": "app/Http/Controllers/DeviceController.php",
    "groupTitle": "Device"
  },
  {
    "type": "post",
    "url": "/live/",
    "title": "Create new live event",
    "name": "LiveCreate",
    "group": "Live",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "app_id",
            "description": "<p>App unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n             \"id\": 1,\n             ...\n         }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/LiveController.php",
    "groupTitle": "Live"
  },
  {
    "type": "put",
    "url": "/live/",
    "title": "Active live event and push notification",
    "name": "LiveUpdate",
    "group": "Live",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Live unique ID.</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "title",
            "description": "<p>Live title.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n             \"id\": 1,\n             ...\n         }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/LiveController.php",
    "groupTitle": "Live"
  },
  {
    "type": "post",
    "url": "/live/finish",
    "title": "Finish live event",
    "name": "LiveFinish",
    "group": "Live",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "id",
            "description": "<p>Live unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n             \"id\": 1,\n             ...\n         }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/LiveController.php",
    "groupTitle": "Live"
  },
  {
    "type": "get",
    "url": "/live/",
    "title": "Get current live event",
    "name": "LiveCurrentEvent",
    "group": "Live",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "app_id",
            "description": "<p>App unique ID.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": {\n             \"id\": 1,\n             ...\n         }\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/LiveController.php",
    "groupTitle": "Live"
  },
  {
    "type": "post",
    "url": "/payment/:charge",
    "title": "Create a charge",
    "name": "PaymentCharge",
    "group": "Payment",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "optional": false,
            "field": "provider",
            "description": "Provicder. Example: VNP | VMS | VTT | MGC"
          },
          {
            "group": "Parameter",
            "optional": false,
            "field": "pin",
            "description": "Pin code. Example: 123456789"
          },
          {
            "group": "Parameter",
            "optional": false,
            "field": "serial",
            "description": "Pin code. Example: 123456789"
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
    "type": "post",
    "url": "/song/:id/buy",
    "title": "Buy a song",
    "name": "BuySong",
    "group": "Payment",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "optional": false,
            "field": "id",
            "description": "Song ID"
          }
        ]
      },
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "",
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
    "filename": "app/Http/Controllers/SongController.php",
    "groupTitle": "Buy Song"
  },
  {
    "type": "post",
    "url": "/album/:id/buy",
    "title": "Buy a album",
    "name": "BuyAlbum",
    "group": "Payment",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "optional": false,
            "field": "id",
            "description": "Album ID"
          }
        ]
      },
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "",
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
    "filename": "app/Http/Controllers/SongController.php",
    "groupTitle": "Buy Song"
  },
  {
    "type": "post",
    "url": "/video/:id/buy",
    "title": "Buy a video",
    "name": "BuyVideo",
    "group": "Payment",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "optional": false,
            "field": "id",
            "description": "Video ID"
          }
        ]
      },
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "",
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
    "filename": "app/Http/Controllers/SongController.php",
    "groupTitle": "Buy Song"
  },
  {
    "type": "get",
    "url": "/payment/songs",
    "title": "List song bought by user",
    "name": "PaymentSongs",
    "group": "Payment",
    "parameter": {
      "fields": {
        "Parameter": [
        ]
      },
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "",
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
    "filename": "app/Http/Controllers/SongController.php",
    "groupTitle": "Payment Songs"
  },
  {
    "type": "get",
    "url": "/payment/albums",
    "title": "List albums bought by user",
    "name": "PaymentAlbums",
    "group": "Payment",
    "parameter": {
      "fields": {
        "Parameter": [
        ]
      },
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "",
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
    "groupTitle": "Payment Albums"
  },
  {
    "type": "get",
    "url": "/payment/videos",
    "title": "List videos bought by user",
    "name": "PaymentVideos",
    "group": "Payment",
    "parameter": {
      "fields": {
        "Parameter": [
        ]
      },
      "examples": [
        {
          "title": "POST Request-Example:",
          "content": "",
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
    "groupTitle": "Payment Videos"
  }
] });
