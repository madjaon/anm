<html>
  <head>
    <meta charset="utf-8">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8" http-equiv="encoding">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>jwplayer test</title>
    <style>
      .jwplayer .jw-rightclick.jw-open {
        display: none !important;
      }
    </style>
    <script src="//content.jwplatform.com/libraries/xSqZrvkA.js"></script>
  </head>
  <body>
    <div id="myDiv">This text will be replaced with a player.</div>
    <script>
      jwplayer("myDiv").setup({
        "playlist": [{
          "title":"One Playlist Item With Multiple Qualities",
          "description":"Two Qualities - One Playlist Item",
          "sources": [
            {
              "file": "",
              "type": "video/mp4",
              "label": "720p"
            },
            {
              "file": "",
              "type": "video/mp4",
              "label": "480p"
            },
            {
              "file": "",
              "type": "video/mp4",
              "label": "360p"
            }
          ]
        }],
        "width": "960",
        "height": "540"
      });
    </script>
  </body>
</html>
