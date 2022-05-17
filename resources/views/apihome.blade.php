<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script lang="javascript">

        window.axios.defaults.withCredentials = true;
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    </script>
</head>
<body>
    TestApi<BR>
        <label id="inform" class="h-12 w-40 bg-red-100">hello</label><BR>
        id : <input type="text" id="id" class="w-40 h-12 border-black bg-gray-100"><BR>
        pwd : <input type="password" id="pwd" class="w-40 h-12 border-black bg-gray-100"><BR>
        <button onclick="onAuth()" class="bg-green-200">Auth</button><BR>
        <button onclick="onLogin()" id="login" class="bg-green-200">Login</button>
        <button onclick="onLogout()" id="logout" class="bg-red-200" disabled>Logout</button><BR>
        <button onclick="onSearch()" class="bg-green-200">조회</button>
    <script>
        const txtId = document.getElementById("id");
        const txtPwd = document.getElementById('pwd');
        const txtResult= document.getElementById('inform');
        const btnLogin= document.getElementById('login');
        const btnLoout= document.getElementById('logout');
        // let token = null;

        function onAuth(){
            axios.get('http://localhost:8000/sanctum/csrf-cookie')
            .then( function(response) {
                console.log(response.config.headers);

            })
        }

        function onLogin(){

            axios.post("http://localhost:8000/api/login", {
                'email' : txtId.value,
                'password' : txtPwd.value,
            })
            .then( function(response) {
                // token = response.data.access_token;
                if(response.data.success != 'ok'){
                    txtResult.innerHTML = response.data.message;
                }else{
                    txtResult.innerHTML = txtId.value + '님 login';
                    btnLogin.disalbed=true;
                }
                return response.data
            })
            .then( (result) => {
                console.log(result);
            })
            .catch( (err) => {
                console.log(err)
            });

        }

        function onLogout(){
            console.log('logout clicked');
        }

        function onSearch(){
            // authtoken = 'Bearer ' + token;

            axios.get("http://localhost:8000/api/user", {
                // headers : {
                //     'Authorization' : authtoken,
                // }
            })
            .then( function(response) {
                return response.data;
            })
            .then( (result) => {
                console.log(result);
            })
            .catch( (err) => {
                console.log(err)
            });
        }
    </script>
</body>
</html>
