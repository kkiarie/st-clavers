<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

       <title>{{$title}}</title>

   
              <style>


            @font-face {
                font-family: 'EB Garamond';
                src: url({{ storage_path("fonts/EB_Garamond/EBGaramond-Bold.ttf") }}) format("truetype");
               font-weight: bold;

            }

            .sp{
                font-family: 'EB Garamond';
                font-style: normal;
                color:red;
            }

        body{
            font-size: 11px;
/*            font-weight: 400;*/
/*           font-family: 'EB Garamond';*/
            color: #000;
        }


    th, td {
  /*border: 1px solid black;*/
  padding: 5px;
  /*text-transform: uppercase;*/
font-family: 'EB Garamond';
}
table {
  border-collapse: collapse;
  border-spacing: 0 1em;
  width: 100%;
  font-family: 'EB Garamond';
}
tr{
    /*padding: 5px;*/
}
th{
    /*text-transform: uppercase;*/
    text-align: left;
}
td{
/*    font-weight: normal;*/
    /*text-transform: uppercase;*/
}
.middle{
    text-align: center;
    font-family: 'EB Garamond';
}
span{
    font-style: normal;
    font-family: 'EB Garamond';
}
/*.title{
    font-size: 14px;
    font-family: 'EB Garamond';
}*/

.td-right{
     text-align: right;
}
.td-left{
     text-align: left;
}

.shaded{
    background: #ccc;

}
.footer {
    width: 100%;
    text-align: center;
    position: fixed;
    font-family: 'EB Garamond';
}
.footer {
    bottom: 0px;
    font-family: 'EB Garamond';
}
.title{
    text-transform: uppercase;
    font-size: 13px;
    font-weight: 400;
    font-family: 'EB Garamond';
}

h3,h1,h2,h4{
      font-weight: bold;
    font-family: 'EB Garamond';  
}
h1{
    font-size: 30px;
    font-weight: bolder;

}
span{
    display: block;
}
.span-one{
font-size: 30px;
font-weight: bold;
}


        </style>
    </head>
<body>

@yield('content')
</body>
</html>