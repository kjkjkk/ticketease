<style>
    .welcome-modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        margin-top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(.5px);
        transition: opacity 0.3s ease;
    }

    .welcome-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        justify-content: center;
        background-color: #e1fff2;
        padding: 30px;
        margin: auto;
        margin-top: 4%;
        border-radius: 8px;
        width: 90%;
        max-width: 400px;
        height: 450px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .welcome-user-img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background-color: #fff;
        outline: 2px solid rgba(0, 0, 0, .6);
    }

    .welcome-user-img img {
        border-radius: 50%;
    }

    .ticketease-container {
        widows: 100%;
        display: flex;
        align-items: center;
    }
</style>
<div id="welcomeModal" class="welcome-modal">
    <div class="welcome-container">
        <div class="ticketease-container">
            <img src="{{ asset('img/logo.png') }}" alt="logo" style="width: 50px; height: 50px;" class="img-fluid">
            <h5 class="fw-bold">Ticket<span class="text-logo-dark">Ease</span></h5>
        </div>
        <div class="welcome-user-img">
            <img src="{{ asset('img/welcome-user.gif') }}" alt="gif" class="img-fluid">
        </div>
        <h5 class="fw-bold">Welcome back <span class="text-indi">{{ auth()->user()->firstname }}</span>!</h5>
        <div class="container d-flex justify-content-center">
            <button type="button" class="close-button btn btn-sm btn-primary form-control">
                LET'S GET STARTED
            </button>
        </div>
    </div>
</div>