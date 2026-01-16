    <script>
        try{
            localStorage.removeItem('token');
            window.location.href = '/';
        }catch(error){
            console.error(error);
        }
    </script>