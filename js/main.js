// convert input text to uppercase
function upperCaseF(a)
{
        a.value = a.value.toUpperCase();
}

// show warning before deleting account or reseting form
function checkDelete()
{
        return confirm('Are You Sure?');
}

// show warning before exiting form edit
function checkSubmit()
{
        return confirm('Are You Sure?\nAll Unsaved Changes Will Be Lost.');
}

// execute after full DOM loading
window.onload=function()
{       
        // start of toggle on/off logout menu
        logout = document.querySelector(".login");
        if (logout)
        {
                logout.addEventListener("click", 
                        function(){
                        this.classList.toggle("active");
                });
        }

        logoutMenu = document.querySelector(".login li");
        if (logoutMenu)
        {
                logoutMenu.addEventListener("click", 
                        function(){
                        this.classList.toggle("active");
                });
        }        
        // end of toggle on/off logout menu    
        
    
        
        //---------------- start of currency seperators ---------------//

        // for the field is inside an input tag value property
        if (typeof balance !== 'undefined')
        {
                var balINR = new Intl.NumberFormat('en-IN', {
                        style: 'currency',
                        currency: 'INR',
                        // display in 'code' format since symbol doesn't print inside a form input
                        currencyDisplay: 'code'
                })                                            
                document.getElementById('balance').value = balINR.format(balance);
        }
       
        // for the field is inside an td/span etc
        if (typeof balance !== 'undefined')
        {
                var balINR = new Intl.NumberFormat('en-IN', {
                        style: 'currency',
                        currency: 'INR'
                })                                            
                document.getElementById('balance').innerHTML = balINR.format(balance);              
        }
        
        // for the field is inside a navigation bar
        if (typeof balanceNav !== 'undefined')
        {
                var balINR = new Intl.NumberFormat('en-IN', {
                        style: 'currency',
                        currency: 'INR'
                })                                            
                document.getElementById('balanceNav').innerHTML = balINR.format(balanceNav);               
        }
        //---------------- end of currency seperators ---------------//
        
}



// ------------------------ login menu/skip client login ----------------------------//
function redirectClient()
{
        if (typeof clientId !== 'undefined')
        {
                window.location.href = 'client/client-dashboard.php';
        }
        else
        {
                loginClient = document.getElementById('buttonClient');
                if (loginClient)
                {
                        document.querySelector('.bg-modal').style.display = 'flex';
                }        

                loginMenuClient = document.querySelector('.close');
                if (loginMenuClient)
                {
                        loginMenuClient.addEventListener('click',
                        function() {
                                document.querySelector('.bg-modal').style.display = 'none';
                        });
                }        
        }
}


// ------------------------ login menu/skip employee login ----------------------------//
function redirectEmployee()
{
        if (typeof employeeId !== 'undefined')
        {
                window.location.href = 'employee/employee-dashboard.php';
        }
        else
        {
                loginEmployee = document.getElementById('buttonEmployee');
                if (loginEmployee)
                {
                        document.querySelector('.bg-modal-employee').style.display = 'flex';
                }        

                loginMenuEmployee = document.querySelector('.close-employee');
                if (loginMenuEmployee)
                {
                        loginMenuEmployee.addEventListener('click',
                        function() {
                                document.querySelector('.bg-modal-employee').style.display = 'none';
                        });
                }         
        }
}


// ------------------------ login menu/skip manager login ----------------------------//
function redirectManager()
{
        if (typeof managerId !== 'undefined')
        {
                window.location.href = 'manager/manager-dashboard.php';
        }
        else
        {
                loginManager = document.getElementById('buttonManager');
                if (loginManager)
                {
                        document.querySelector('.bg-modal-manager').style.display = 'flex';
                }        

                loginMenuManager = document.querySelector('.close-manager');
                if (loginMenuManager)
                {
                        loginMenuManager.addEventListener('click',
                        function() {
                                document.querySelector('.bg-modal-manager').style.display = 'none';
                        });
                }         
        }
}