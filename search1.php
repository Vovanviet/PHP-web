<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }
        * {
            margin: 0;
            padding: 0;
            font: inherit;
        }
        body {
            line-height: 1.5;
        }
        img,
        picture,
        video,
        canvas,
        svg {
            display: block;
            max-width: 100%;
        }
        input,
        button,
        textarea,
        select {
            outline: none;
        }
        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            overflow-wrap: break-word;
        }
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@200&family=Lato:wght@300;400&family=Open+Sans:ital,wght@0,400;0,500;1,300;1,400&family=Oswald:wght@200;300;400;500&family=Roboto:ital,wght@0,300;0,400;0,500;1,400&family=Source+Code+Pro:ital,wght@0,300;0,400;0,500;1,300;1,400&display=swap');
        html {
            font-size: 62.5%;
        }
        body {
            font-family: "Poppins", "roboto", sans-serif;
            font-size: 1.6rem;
        }
        .search-box {
            width: 30rem;
            position: relative;
            display: inline-block;
            font-size: 1.4rem;
        }
        .search-box input[type="text"] {
            height: 3.2rem;
            padding: 0.5rem 1rem;
            border: 1px solid #ccc;
            font-size: 1.4rem;
        }
        .result {
            position: absolute;
            z-index: 2;
            top: 100%;
            left: 0;
        }
        .search-box input[type="text"] .result {
            width: 100%;
        }
        /* Formatting result items */
        .result p {
            margin: 0;
            padding: 0.7rem 1rem;
            border: 1px solid #ccc;
            border-top: none;
            cursor: pointer;
        }
        .result p:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="search-box">
        <input type="text" autocomplete="off" placeholder="Search student...">
        <div class="result"></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.search-box input[type="text"]').on("keyup input", function() {
                // Get input value on change
                var inputVal = $(this).val();
                var resultDropdown = $(this).siblings(".result");
                if (inputVal.length) {
                    $.get("backend.php", {
                        term: inputVal
                    }).done(function(data) {
                        // Display the returned data in browser
                        resultDropdown.html(data);
                    });
                } else {
                    resultDropdown.empty();
                }
            })
            // Set search input value on click of result item
            $(document).on("click", ".result p", function() {
                $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
                $(this).parent(".result").empty();
            })
        })
    </script>
</body>
</html>