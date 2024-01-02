function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

function deleteimage(a, b, c, d, e, f)
{
    //alert(d);
    if (window.XMLHttpRequest)
    {
        oRequestsubcat = new XMLHttpRequest();
    } else if (window.ActiveXObject)
    {
        oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (a != '' && b != '' && c != '' && d != '' && e != '' && f != '')
    {
        document.getElementById("delimage").innerHTML = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
        oRequestsubcat.open("POST", Settings.base_url + "config/functions_ajax.php", true);
        oRequestsubcat.onreadystatechange = delimg;
        oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        oRequestsubcat.send("image=" + a + "&id=" + b + "&table=" + c + "&path=" + d + "&images=" + e + "&pid=" + f);
        //console.log(a, b, c, d, e, f);
    }
}

function delimg()
{
    if (oRequestsubcat.readyState == 4)
    {
        if (oRequestsubcat.status == 200)
        {
            document.getElementById("delimage").innerHTML = oRequestsubcat.responseText;
        } else
        {
            document.getElementById("delimage").innerHTML = oRequestsubcat.responseText;
        }


    }
}

 
function deletemultiimage(a, b, c, d, e, f, disid)
{
    var iid;
    iid = disid;
    //alert(disid);
    if (window.XMLHttpRequest)
    {
        oRequestsubcat = new XMLHttpRequest();
    } else if (window.ActiveXObject)
    {
        oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (a != '' && b != '' && c != '' && d != '' && e != '' && f != '')
    {
        document.getElementById(iid).innerHTML = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i>Succesfully Deleted</h4></div>';
        oRequestsubcat.open("POST", Settings.base_url + "config/functions_ajax.php", true);
        oRequestsubcat.onreadystatechange = delimg1(iid);
        oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        oRequestsubcat.send("image=" + a + "&id=" + b + "&table=" + c + "&path=" + d + "&images=" + e + "&pid=" + f);
        // console.log(a, b, c, d, e, f);
    }
}

function delimg1(iid)
{
    var iid;
    iid = iid;
    
    if (oRequestsubcat.readyState == 4)
    {
        if (oRequestsubcat.status == 200)
        {
            document.getElementById(iid).innerHTML = oRequestsubcat.responseText;
        } else
        {
            document.getElementById(iid).innerHTML = oRequestsubcat.responseText;
        }
    }
}

function deleteimagevehiclemaster(a, b)
{
    if (window.XMLHttpRequest)
    {
        oRequestsubcat = new XMLHttpRequest();
    } else if (window.ActiveXObject)
    {
        oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (a != '' && b != '')
    {
        document.getElementById("delmaster").innerHTML = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
        oRequestsubcat.open("POST", "https://www.nbayjobs.com/nbaysmarthtml/results/", true);
        oRequestsubcat.onreadystatechange = delmasterimages;
        oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        oRequestsubcat.send("a=" + a + "&b=" + b);
    }
}

function delmasterimages()
{
    if (oRequestsubcat.readyState == 4)
    {
        if (oRequestsubcat.status == 200)
        {
            document.getElementById("delmaster").innerHTML = oRequestsubcat.responseText;
        } else
        {
            document.getElementById("delmaster").innerHTML = oRequestsubcat.responseText;
        }
    }
}


function getstate(a)
{
    if (window.XMLHttpRequest)
    {
        oRequestsubcat = new XMLHttpRequest();
    } else if (window.ActiveXObject)
    {
        oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (a != '')
    {
        document.getElementById("state").innerHTML = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
        oRequestsubcat.open("POST", "http://192.168.1.8/config/function_ajax.php", true);
        oRequestsubcat.onreadystatechange = showstate;
        oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        oRequestsubcat.send("country=" + a);
    }
}

function showstate()
{
    if (oRequestsubcat.readyState == 4)
    {
        if (oRequestsubcat.status == 200)
        {
            document.getElementById("state").innerHTML = oRequestsubcat.responseText;
        } else
        {
            document.getElementById("state").innerHTML = oRequestsubcat.responseText;
        }
    }
}


function getcity(a, b)
{
    if (window.XMLHttpRequest)
    {
        oRequestsubcat = new XMLHttpRequest();
    } else if (window.ActiveXObject)
    {
        oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (a != '' && b != '')
    {
        document.getElementById("state").innerHTML = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
        oRequestsubcat.open("POST", "http://192.168.1.8/config/function_ajax.php", true);
        oRequestsubcat.onreadystatechange = showcity;
        oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        oRequestsubcat.send("country=" + a + "&state=" + b);
    }
}

function showcity()
{
    if (oRequestsubcat.readyState == 4)
    {
        if (oRequestsubcat.status == 200)
        {
            document.getElementById("city").innerHTML = oRequestsubcat.responseText;
        } else
        {
            document.getElementById("city").innerHTML = oRequestsubcat.responseText;
        }
    }
}

function deleteimagebanner(a, b, c, d, e, f)
{

    if (window.XMLHttpRequest)
    {
        oRequestsubcat = new XMLHttpRequest();
    } else if (window.ActiveXObject)
    {
        oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (a != '' && b != '' && c != '' && d != '' && e != '' && f != '')
    {
        document.getElementById("delimageb").innerHTML = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
        oRequestsubcat.open("POST", "https://www.nbayjobs.com/nbaysmarthtml/results/", true);
        oRequestsubcat.onreadystatechange = delimgbanner;
        oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        oRequestsubcat.send("image=" + a + "&id=" + b + "&table=" + c + "&path=" + d + "&images=" + e + "&pid=" + f);
        console.log(a, b, c, d, e, f);
    }
}

function delimgbanner()
{
    if (oRequestsubcat.readyState == 4)
    {
        if (oRequestsubcat.status == 200)
        {
            document.getElementById("delimageb").innerHTML = oRequestsubcat.responseText;
        } else
        {
            document.getElementById("delimageb").innerHTML = oRequestsubcat.responseText;
        }


    }
}

function deleteimagecimage(a, b, c, d, e, f)
{

    if (window.XMLHttpRequest)
    {
        oRequestsubcat = new XMLHttpRequest();
    } else if (window.ActiveXObject)
    {
        oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (a != '' && b != '' && c != '' && d != '' && e != '' && f != '')
    {
        document.getElementById("delimageci").innerHTML = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
        oRequestsubcat.open("POST", "https://www.nbayjobs.com/nbaysmarthtml/results/", true);
        oRequestsubcat.onreadystatechange = delimgcimage;
        oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        oRequestsubcat.send("image=" + a + "&id=" + b + "&table=" + c + "&path=" + d + "&images=" + e + "&pid=" + f);
        console.log(a, b, c, d, e, f);
    }
}

function delimgcimage()
{
    if (oRequestsubcat.readyState == 4)
    {
        if (oRequestsubcat.status == 200)
        {
            document.getElementById("delimageci").innerHTML = oRequestsubcat.responseText;
        } else
        {
            document.getElementById("delimageci").innerHTML = oRequestsubcat.responseText;
        }


    }
}

function getdesig(a)
{

    if (window.XMLHttpRequest)
    {
        oRequestsubcat = new XMLHttpRequest();
    } else if (window.ActiveXObject)
    {
        oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
    }
    pagename = a;
    document.getElementById("designation").innerHTML = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';

    oRequestsubcat.open("POST", "https://www.nbayjobs.com/nbaysmarthtml/results/", true);
    oRequestsubcat.onreadystatechange = showdesig;
    oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    oRequestsubcat.send("desid=" + pagename);
}

function showdesig()
{
    if (oRequestsubcat.readyState == 4)
    {
        if (oRequestsubcat.status == 200)
        {
            document.getElementById("designation").innerHTML = oRequestsubcat.responseText;
        } else
        {
            document.getElementById("designation").innerHTML = oRequestsubcat.responseText;
        }
    }
}

function deleteimagemaster(a, b, c)
{
    if (window.XMLHttpRequest)
    {
        oRequestsubcat = new XMLHttpRequest();
    } else if (window.ActiveXObject)
    {
        oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (a != '' && b != '' && c != '')
    {
        document.getElementById("delmaster").innerHTML = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
        oRequestsubcat.open("POST", "https://www.nbayjobs.com/nbaysmarthtml/results/", true);
        oRequestsubcat.onreadystatechange = delmasterimage;
        oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        oRequestsubcat.send("a=" + a + "&b=" + b + "&c=" + c);
    }
}

function delmasterimage()
{
    if (oRequestsubcat.readyState == 4)
    {
        if (oRequestsubcat.status == 200)
        {
            document.getElementById("delmaster").innerHTML = oRequestsubcat.responseText;
        } else
        {
            document.getElementById("delmaster").innerHTML = oRequestsubcat.responseText;
        }
    }
}

function agent(a)
{

    if (window.XMLHttpRequest)
    {
        oRequestsubcat = new XMLHttpRequest();
    } else if (window.ActiveXObject)
    {
        oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
    }
    pagename = a;
    document.getElementById("customer").innerHTML = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';

    oRequestsubcat.open("POST", "https://www.nbayjobs.com/nbaysmarthtml/results/", true);
    oRequestsubcat.onreadystatechange = showagent;
    oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    oRequestsubcat.send("agentid=" + pagename);
}

function showagent()
{
    if (oRequestsubcat.readyState == 4)
    {
        if (oRequestsubcat.status == 200)
        {
            document.getElementById("customer").innerHTML = oRequestsubcat.responseText;
        } else
        {
            document.getElementById("customer").innerHTML = oRequestsubcat.responseText;
        }
    }
}

function printDiv(divId) {
    var printContents = document.getElementById(divId).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

function setlocsess(a)
{
    if (window.XMLHttpRequest)
    {
        oRequestsubcat = new XMLHttpRequest();
    } else if (window.ActiveXObject)
    {
        oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
    }
    pagename = a;
    document.getElementById("loca-category").innerHTML = '';
    oRequestsubcat.open("POST", "https://www.nbayjobs.com/nbaysmarthtml/results/", true);
    oRequestsubcat.onreadystatechange = showlocc;
    oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    oRequestsubcat.send("locid=" + pagename);
}

function showlocc()
{
    if (oRequestsubcat.readyState == 4)
    {
        if (oRequestsubcat.status == 200)
        {
            document.getElementById("loca-category").innerHTML = oRequestsubcat.responseText;
        } else
        {
            document.getElementById("loca-category").innerHTML = oRequestsubcat.responseText;
        }
    }
}


function delimag(a)
{
    //alert('yes');
    if (window.XMLHttpRequest)
    {
        oRequestsubcat = new XMLHttpRequest();
    } else if (window.ActiveXObject)
    {
        oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if (a != '')
    {
        document.getElementById("delmaster").innerHTML = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
        oRequestsubcat.open("POST", Settings.base_url + "config/functions_ajax.php", true);
        oRequestsubcat.onreadystatechange = delimags;
        oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        oRequestsubcat.send("delimag=" + a);
    }
}

function delimags()
{
    if (oRequestsubcat.readyState == 4)
    {
        if (oRequestsubcat.status == 200)
        {
            document.getElementById("delmaster").innerHTML = oRequestsubcat.responseText;
        }
        else
        {
            document.getElementById("delmaster").innerHTML = oRequestsubcat.responseText;
        }
    }
}