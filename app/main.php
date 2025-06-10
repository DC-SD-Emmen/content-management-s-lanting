<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
<body>

    <form method="POST">
        <input type='text' name='plantname' placeholder="Plantname">
        <input type='submit name='submit'>
    </form>


    <script>

        //form onsubmit prevent default, stop propagation

        $('form').submit(function(e) {
            e.preventDefault();
            e.stopPropagation();

            var formData = $(this).serialize();

            $.ajax({
                url: 'testapi.php',
                type: 'POST',
                data: formData,
                success: function(data) {
                    console.log(data);
                },
                error: function(xhr, status, error) {
                    console.log('Error', xhr.statusText);
                }
            });
        });

    </script>
    
</body>
</html>