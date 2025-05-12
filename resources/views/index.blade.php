<!DOCTYPE html>
<html>

<head>
    <title>BUNS</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('/images/background.jpg') no-repeat center center;
            background-size: cover;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: white;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        nav a,
        .login-btn {
            font-weight: bold;
            text-decoration: none;
            color: black;
        }

        .login-btn {
            background: red;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }



        

        .role-badge {
            background-color: red;
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-weight: bold;
        }

        .user-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 40px;
            right: 0;
            background-color: #b30000;
            border-radius: 10px;
            padding: 10px;
            z-index: 999;
            min-width: 150px;
        }

        .dropdown-content a,
        .dropdown-content form button {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            color: white;
            text-decoration: none;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-size: 14px;
        }

        .dropdown-content a:hover,
        .dropdown-content form button:hover {
            background-color: #a00000;
            border-radius: 5px;
        }

        .user-menu:hover .dropdown-content {
            display: block;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-box {
            width: 700px;
            background: white;
            border-radius: 20px;
            margin: 8% auto;
            display: flex;
            overflow: hidden;
            transition: 0.3s ease;
        }

        .panel {
            width: 50%;
            padding: 40px 30px;
            box-sizing: border-box;
            transition: transform 0.5s ease;
        }

        .left-panel {
            background: #b30000;
            color: white;
        }

        .right-panel {
            background: white;
        }

        .panel h3 {
            margin-bottom: 20px;
        }

        .panel input {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ccc;
        }

        .panel button {
            padding: 10px 20px;
            border-radius: 20px;
            border: none;
            cursor: pointer;
        }

        .signup-btn {
            background: white;
            color: #b30000;
            border: 2px solid white;
        }

        .signin-btn {
            background: #b30000;
            color: white;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 30px;
            font-size: 24px;
            color: white;
            cursor: pointer;
        }

        /* Slide Logic */
        .modal-box.shift .left-panel {
            transform: translateX(100%);
        }

        .modal-box.shift .right-panel {
            transform: translateX(-100%);
        }
    </style>
</head>

<body>

    <header>
        <div>BUNS</div>
        <nav>
            <a href="#">ABOUT</a>
            <a href="#">CLASS</a>
            <a href="#">GALLERY</a>

            @if(session('user'))
            <div class="user-menu">
                <button class="role-badge" id="roleButton">
                    {{ strtoupper(session('user')->role) }}
                </button>
                <img src="{{ asset('images/user-icon.png') }}" alt="User Icon" class="user-icon" id="userIcon">
                <div class="dropdown-content" id="dropdownContent">
                    <a href="#">Profile</a>
                    <a href="#">History</a>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>
            @else
            <button class="login-btn" onclick="openModal()">LOGIN</button>
            @endif
        </nav>
    </header>

    <!-- Modal -->
    <div id="popupModal" class="modal">
        <div class="modal-box" id="modalBox">
            <div class="panel left-panel">
                <h3>Welcome Back</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" class="signin-btn">Sign In</button>
                </form>
                <p style="margin-top:20px;">Don't have an account?</p>
                <button onclick="shiftToRegister()" class="signup-btn">Sign Up</button>
            </div>
            <div class="panel right-panel">
                <h3>Create Account</h3>
                <form method="POST" action="{{ route('register.store') }}">
                    @csrf
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" class="signin-btn">Register</button>
                </form>
                <p style="margin-top:20px;">Already have an account?</p>
                <button onclick="shiftToLogin()" class="signup-btn">Sign In</button>
            </div>
        </div>
        <span class="close" onclick="closeModal()">&times;</span>
    </div>


    <script>
        function openModal() {
            document.getElementById('popupModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('popupModal').style.display = 'none';
            document.getElementById('modalBox').classList.remove('shift');
        }

        function shiftToRegister() {
            document.getElementById('modalBox').classList.add('shift');
        }

        function shiftToLogin() {
            document.getElementById('modalBox').classList.remove('shift');
        }

        window.onclick = function(event) {
            if (event.target === document.getElementById('popupModal')) {
                closeModal();
            }
        }

        const userIcon = document.getElementById('userIcon');
        const dropdown = document.getElementById('dropdownContent');
        const roleButton = document.getElementById('roleButton');
        const memberCardModal = document.getElementById('memberCardModal');

        let dropdownOpen = false;

        // Toggle dropdown on icon click
        userIcon.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.style.display = dropdownOpen ? 'none' : 'block';
            dropdownOpen = !dropdownOpen;
        });

        // Show member card if role is MEMBER
        roleButton.addEventListener('click', () => {
            const role = roleButton.textContent.trim().toUpperCase();
            if (role === 'MEMBER') {
                memberCardModal.style.display = 'block';
            }
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', () => {
            dropdown.style.display = 'none';
            dropdownOpen = false;
        });

        // Close member modal
        function closeMemberCard() {
            memberCardModal.style.display = 'none';
        }
    </script>

</body>

</html>