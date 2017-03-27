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
            "field": "plat_form",
            "description": "<p>Platform. Eg: ios, android</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": [\n         \"content_id\": 1,\n         \"version\": 1.0.1,\n     ]\n }",
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
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": [\n         \"albums\": {...},\n         \"songs\": {...},\n         \"videos\": {...}\n     ]\n }",
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
    "url": "/auth/",
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
          "content": "HTTP/1.1 200 OK\n\n {\n     \"error\": false,\n     \"data\": [\n         \"token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIU...\",\n         \"auth\": {...}\n     ]\n }",
          "type": "json"
        }
      ]
    },
    "version": "1.0.0",
    "filename": "app/Http/Controllers/UserController.php",
    "groupTitle": "User"
  }
] });
