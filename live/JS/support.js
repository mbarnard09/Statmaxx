function philosophy() {
    resetColor();
    document.getElementById("maintext").innerHTML = `<h1>Social trading</h1>The philosophy is simple; There was a gap in the trading tools market.
    No one had found a way to effetively trade on one of the fundemental principles of the stock market, emotion. Emotion is a huge 
    factor in determining the movement on a stock, especially in this market climate. Stocks can run up, or down for that matter solely
    based on a market feeling or emotion. This can come from news or it can come from nothing, regardless we want you to be ahead of the rest.
     With our sentiment tools you can analyze the market mood to stay ahead of emotion based movements. Another huge use for the 
     tools currently on the site are for breakouts. This is where the site really stands out from others. With the daily change analysis
     you are able to see when a stock has gone from virtually no chatter, to a rise in chatter, and finally to a breakout. Comment volume
     means actual volume but there is normally a hype up on forums before any of this happens and no single person can keep track of all 
     the different catalysts at once but with StatMaxx you can. The site is just starting out and more and more tools will be 
     written and upgrades will made to our algoithyms all the time. <br><br>
     We hope you enjoy the site and please don´t hesitate to email us, <br>
     Thanks, <br>
     Mathew and Josh, a.k.a  MaJo  (The StatMaxx Team) `;
    document.getElementById("philosophy").style.background = "rgb(227, 227, 227)";
}
function support() {
    resetColor();
    document.getElementById("maintext").innerHTML = `For any questions, comments, concerns or suggestions do not hesitate to email 
    us.. We actually love feedback.<br><br><a href = 'mailto: statmaxxad@gmail.com' class='maintext'>Statmaxxad@gmail.com</a><br><br>
    Thanks, <br><br>StatMaxx Team`;
    document.getElementById("support").style.background = "rgb(227, 227, 227)";
}
function changelog() {
    resetColor();
    document.getElementById("maintext").innerHTML = `<h1>Version History</h1><br><div class="alignleft"><strong>Version 1.0.0 Early August 2020 - Welcome to StatMaxx</strong><br>-Initial release.</div><br> <div class="alignleft"><strong>Version 1.1.0 Early September 2020 - Just Getting Started</strong><br>-Bug Fixes and Efficiency Improvements. New features coming soon. </div>`;
    document.getElementById("changelog").style.background = "rgb(227, 227, 227)";
}
function comingsoon() {
    resetColor();
    document.getElementById("maintext").innerHTML = `<h1>We are always working on new things. Here's what you can expect 
in the near future.</h1><br><div class="alignleft"><strong>Options Trading Calculator</strong><br>   -A tool to calculate max profit and loss in your options trades.<br><strong>Advanced Sentiment Analysis</strong><br>-A tool for using our data in other meaningful ways.<br><strong>Unusual Volume Screener</strong><br>-A tool to track sudden or unusual volume in stocks and options.<br><strong>Account Features</strong><br>-Account features e.g. favorite symbols</div>`;
    document.getElementById("comingsoon").style.background = "rgb(227, 227, 227)";
}
function other() {
    resetColor();
    document.getElementById("maintext").innerHTML = "Oops! Looks like there's nothing here yet..";
    document.getElementById("other").style.background = "rgb(227, 227, 227)";
}
function resetColor() {
    document.getElementById("support").style.background = "white";
    document.getElementById("philosophy").style.background = "white";
    document.getElementById("changelog").style.background = "white";
    document.getElementById("comingsoon").style.background = "white";
    document.getElementById("other").style.background = "white";
}
