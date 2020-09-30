const tombolMenu = document.querySelector('.mobileToggle');
const menuList = document.querySelector('.menu');
const modal = document.querySelector('.modal');
const close = document.querySelector('.modal .close');
const modalList = document.querySelectorAll('.modal .listModal span');
const modalTitle = document.querySelector('.modal .heading h4');
const searchInput = document.querySelector('.search input');

const dataProv = document.querySelectorAll('.listProv ul li');
dataProv.forEach(function(el){
	el.addEventListener('click', function(){
		const kode = el.getAttribute('data-prov');
		const posi = el.getAttribute('posi');
 		const sem = el.getAttribute('sem');
 		const meni = el.getAttribute('meni');
 		// el.style.background = 'red';
		modal.style.display = 'block';
		modalTitle.textContent = kode;
		modalList[0].textContent = posi;
		modalList[1].textContent = sem;
		modalList[2].textContent = meni;
	})
});


tombolMenu.onclick = function(){
	this.classList.toggle('active');
	menuList.classList.toggle('active');
}

close.onclick = function(){
	modal.style.display = 'none';
}

window.onclick = function(e) {
	if(e.target != tombolMenu && e.target != menuList )
	{
		tombolMenu.classList.remove('active');
		menuList.classList.remove('active');
	}
}


function liveSearch()
{
	var input, filter, ul, li, a, i, txtValue;
	input = document.querySelector('.search input');
	filter = input.value.toUpperCase();
	ul = document.querySelector('aside .listProv ul');
	li = ul.getElementsByTagName('li');

	for(i = 0; i < li.length; i++)
	{
		txtValue = li[i].textContent || li[i].innerText;
		if( txtValue.toUpperCase().indexOf(filter) > -1 )
		{
			li[i].style.display = '';
		} else {
			li[i].style.display = 'none';
		}

	}
		// console.log(txtValue);
}


document.querySelector('.search input').addEventListener('keydown', function() {
	liveSearch();
})
