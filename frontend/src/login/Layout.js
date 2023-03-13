import React from 'react';
import "../common/css/Zonesoft.css"
//import Data from './Data';


function Layout(){

  return (
		<main>
<script src="https://accounts.google.com/gsi/client" async defer></script>	
				
<div id="g_id_onload"
     data-client_id="884346004784-2b1v345e8fcgubppetoand01o2frnvqu.apps.googleusercontent.com"
     data-context="signin"
     data-ux_mode="redirect"
     data-login_uri="http://localhost:3000/"
     data-auto_prompt="false">
</div>

<div className="g_id_signin"
     data-type="standard"
     data-shape="pill"
     data-theme="outline"
     data-text="signin_with"
     data-size="large"
     data-logo_alignment="left">
</div>
					

</main>
  );
}

export default Layout;