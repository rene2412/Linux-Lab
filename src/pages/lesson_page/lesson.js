const sidebarBtn = document.querySelector('.top__sidebar');
const sidebarBtnClose = document.querySelector('.sidebar__button')
const sidebar = document.querySelector('.sidebar');

sidebarBtn.addEventListener('click',()=>{
    sidebar.classList.toggle('hidden');
})
sidebarBtnClose.addEventListener('click',()=>{
    sidebar.classList.toggle('hidden');
})