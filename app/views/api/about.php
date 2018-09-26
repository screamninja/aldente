<?php echo 'ABOUT PAGE'; ?>

<ul>
    <li><a href="/">Main page</a><br></li>
    <li><a href="/api/about">API</a><br></li>
    <li><a href="../account/login">Login page</a><br></li>
    <li><a href="../account/register">Register page</a><br></li>
</ul>

<ul>
    <li><a href="/api/token">Get API Token</a><br></li>
</ul>

<div>
    <p>API Response Example</p>
    <pre>
{
    "jsonrpc": "2.0",
    "error": [
        {
            "code": "-32601",
            "message": "Method not found"
        }
    ],
    "id": "1"
}
    </pre>
</div>