{literal}
    <style>
        .PracticePortal {
            display: block;
            background: #FFF;
            position:relative;
            min-height:350px;
            overflow:hidden;
        }
        .introduction {
            position:absolute;
            min-height: 350px;
            margin-right:150px;
        }
        .treatmentMan {
            height: 350px;
            width: 150px;
            background: url('{/literal}{$treatmentman}{literal}') no-repeat;
            position: absolute;
            right: 0;
        }
        .locationSelector {
            position:absolute;
            padding: 0;
            margin: 0;
            height: 30px;
            width: 30px;
            border-radius: 8px;
            background: #ffc578;
            background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2ZmYzU3OCIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNmYjlkMjMiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
            background: -moz-linear-gradient(top, #ffc578 0%, #fb9d23 100%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffc578), color-stop(100%,#fb9d23));
            background: -webkit-linear-gradient(top, #ffc578 0%,#fb9d23 100%);
            background: -o-linear-gradient(top, #ffc578 0%,#fb9d23 100%);
            background: -ms-linear-gradient(top, #ffc578 0%,#fb9d23 100%);
            background: linear-gradient(to bottom, #ffc578 0%,#fb9d23 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffc578', endColorstr='#fb9d23',GradientType=0 );
            opacity: 0.8;
        }
        .locationSelector:hover {
            opacity: 0.9;
        }
        .locationQuestions {
            position:absolute;
            margin-left: 150px;
            left:100%;
            right:-100%;
            height:100%;
        }
        .questionSelector {
            display:block;
            width: 100%;
        }
        .questionContent {
            position:absolute;
            display:block;
            right: -100%;
            top:0;
            width: 50%;
            height: 100%;
            background: #FFF;
            padding-left: 20px;
        }
        .questionContentClose {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            height: 100%;
            width: 20px;
            font-size:large;
            background:#ddd;
            border:none;
            padding:0;
        }
        .conditionList {
            position: absolute;
            display:none;
            height: 100%;
            width: 100%;
            background: white;
        }
        .conditionList, .condition, .practitioner, .locationQuestions, .questionContent {
            overflow-y: auto;
            overflow-x: hidden;
        }
        .condition,.practitioner{
            position:absolute;
            display:none;
            height: 100%;
            width: 100%;
            background: white;
        }
        .practitionerOption {
            width: 100%;
            display:block;
            text-align:left;
        }
        .practitionerOptionVideo {
            float:left;
        }
        .practitionerOptionName,.practitionerOptionBio {
            margin-left: 200px;
        }
        .block {
            display: block;
        }
    </style>
{/literal}