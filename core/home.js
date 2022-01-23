var cur_ptr=1;
var total=3;
function slide(x)
{
	var image=document.getElementById("slider-img");
	var txt=document.getElementById("content-txt");
	cur_ptr=cur_ptr+x;
	if(cur_ptr>total){cur_ptr=1;}
	if(cur_ptr<1){cur_ptr=total;}
	image.src="core/images/img"+cur_ptr+".jpg";
	if(cur_ptr==1){txt.textContent="DISCOVER ENDLESS WAYS TO CUSTOMIZE YOUR IDEA";}
	if(cur_ptr==2){txt.textContent="REFLECT YOUR PERSONALITY";}
	if(cur_ptr==3){txt.textContent="CREATE YOUR OWN PATH";}
}
window.setInterval(function slideA()
{
	var image=document.getElementById("slider-img");
	var txt=document.getElementById("content-txt");
	cur_ptr=cur_ptr+1;
	if(cur_ptr>total){cur_ptr=1;}
	if(cur_ptr<1){cur_ptr=total;}
	image.src="core/images/img"+cur_ptr+".jpg";
	if(cur_ptr==1){txt.textContent="DISCOVER ENDLESS WAYS TO CUSTOMIZE YOUR IDEA";}
	if(cur_ptr==2){txt.textContent="REFLECT YOUR PERSONALITY";}
	if(cur_ptr==3){txt.textContent="CREATE YOUR OWN PATH";}},5000);

