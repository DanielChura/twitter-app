<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
    }

    section {
        width: 100%;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    div {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        gap: 1rem;
    }

    button {
        padding: 1rem 2rem;
        background-color: deepskyblue;
        border: 1px solid deepskyblue;
        color: #fff;
        border: none;
        border-radius: 500px;
        cursor: pointer;
        transition: all 0.3s;
    }

    button:hover {
        background-color: #fff;
        color: deepskyblue;
    }

    h1 {
        font-size: 3rem;
    }

    p {
        font-size: 1rem;
    }

    img {
        margin-top: 1rem;
    }
</style>

<body>
    <section>
        <div>
            <h1>Uh oh!</h1>
            <h2>Error: <?= http_response_code() ?> </h2>
            <p>Ocurrió un error inesperado</p>
            <p>Intentaremos resolverlo lo más pronto posible</p>
            <form action="<?=url('/home')?>" method="get">
                <button>Ir al home</button>
            </form>

            <img width="500px" src="https://upload.wikimedia.org/wikipedia/commons/2/23/Golang.png?utm_source=commons.wikimedia.org&utm_campaign=index&utm_content=original">
        </div>

    </section>
</body>

</html>