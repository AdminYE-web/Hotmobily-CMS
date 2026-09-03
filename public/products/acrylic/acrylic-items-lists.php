<style>
    .d-flex {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .frame-item {
        width: 30%;
        padding: 10px;
        border: 1px solid #e5e5e5;
        margin-bottom: 10px;
        position: relative;
        text-align: center;
        /* height: fit-content; */
    }

    .frame-item a {
        color: black !important;
        text-decoration: none !important;
    }

    .frame-item h3 {
        margin-bottom: 10px;
    }

    .frame-item img {
        width: auto;
        margin-bottom: 10px;
        max-height: 150px;
        max-width: 100%;
    }

    img.item {
        width: 30%;
        max-width: 90px !important;
        max-height: 72px !important;
    }

    @media screen and (max-width: 768px) {
        .frame-item {
            width: 48% !important;
            box-sizing: border-box;
        }

        .mb {
            display: block;
        }

        .d-flex.justify-content-between.text-center {
            overflow: hidden;
            height: 604px;
            position: relative;
        }

    }

    @media (max-width: 768px) {
    
        .frame-item {
            width: 48% !important;
        }

        .bulk {
            display: flex;
            gap: 5px;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-between;
        }
    }

    @media (max-width: 576px) {
        .frame-item {
            width: 48% !important;
        }
    }
</style>

<?php 
    $path_grid = __DIR__ . "/acrylic-grid.php";
    if (file_exists($path_grid)) {
        include($path_grid);
    }    
?>
