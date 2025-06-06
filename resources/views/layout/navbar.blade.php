<style>
    .navbar-custom {
        background-color: #1c3b2b;
        padding: 20px 0;
        height: 202px;
        position: relative;
        z-index: 0;
        border-bottom-left-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .wave-container {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 100%;
        display: flex;
        justify-content: flex-end;
        /* height: auto; */
        pointer-events: none;
        z-index: -1;
        overflow: hidden;
        /* Mencegah overflow akibat overlap */
    }

    .wave {
        position: relative;
        bottom: 0;
        overflow: hidden;
    }

    .wave-left {
        width: 70%;
        height: 182px;
        position: relative;
        margin-right: -50%;
        bottom: -50px;

        z-index: -1;
    }
    .wave-left img{
        bottom: -50px;
    }

    .wave-right {
        right: 0;
        overflow: hidden;
        z-index: 1;
        position: relative;
        width: 70%;
        height: 181px;
        

    }
</style>
<nav class="navbar navbar-expand navbar-bg navbar-custom
">
    <a class="sidebar-toggle js-sidebar-toggle mx-4">
        <i class="hamburger align-self-center "></i>
    </a>
    <div class="wave-container">
        <div class="wave-left">
            <img class="" src="/assets/Vector 8.svg" alt="Wave Left">   
        </div>
        <div class="wave-right">
            <img class="" src="/assets/Vector 8.svg" alt="Wave Right">

        </div>
    </div>
    <div class="navbar-collapse collapse d-flex flex-column align-items-start">
        <h1 class="text-white text-start">{{ $title ?? '' }}</h1>
        <h4 class="text-white text-start">{{ $description ?? '' }}</h4>
    </div>
    

</nav>

