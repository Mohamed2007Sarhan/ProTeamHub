const toggleButton = document.getElementById('toggle-btn')
const sidebar = document.getElementById('sidebar')

function toggleSidebar() {
  sidebar.classList.toggle('close')
  toggleButton.classList.toggle('rotate')

  closeAllSubMenus()
}

function toggleSubMenu(button) {

  if (!button.nextElementSibling.classList.contains('show')) {
    closeAllSubMenus()
  }

  button.nextElementSibling.classList.toggle('show')
  button.classList.toggle('rotate')

  if (sidebar.classList.contains('close')) {
    sidebar.classList.toggle('close')
    toggleButton.classList.toggle('rotate')
  }
}

function closeAllSubMenus() {
  Array.from(sidebar.getElementsByClassName('show')).forEach(ul => {
    ul.classList.remove('show')
    ul.previousElementSibling.classList.remove('rotate')
  })
}








const toggleButton1 = document.getElementById("theme-toggle");
const themeIcon = document.getElementById("theme-icon");
const themeText = document.getElementById("theme-text");

toggleButton1.addEventListener("click", function() {
  // تبديل الوضع بين المظلم والفاتح
  if (document.body.getAttribute('data-theme') === 'dark') {
    document.body.setAttribute('data-theme', 'light');
    localStorage.setItem('theme', 'light');  // حفظ التفضيل في التخزين المحلي
    themeIcon.classList.remove('fa-moon');   // إزالة أيقونة القمر
    themeIcon.classList.add('fa-sun');       // إضافة أيقونة الشمس
    themeText.textContent = 'Light Mode';    // تغيير النص إلى Light Mode
  } else {
    document.body.setAttribute('data-theme', 'dark');
    localStorage.setItem('theme', 'dark');   // حفظ التفضيل في التخزين المحلي
    themeIcon.classList.remove('fa-sun');    // إزالة أيقونة الشمس
    themeIcon.classList.add('fa-moon');      // إضافة أيقونة القمر
    themeText.textContent = 'Dark Mode';     // تغيير النص إلى Dark Mode
  }
});

// استرجاع التفضيل المحفوظ من التخزين المحلي عند تحميل الصفحة
const savedTheme = localStorage.getItem('theme');
if (savedTheme) {
  document.body.setAttribute('data-theme', savedTheme);
  if (savedTheme === 'dark') {
    themeIcon.classList.remove('fa-sun');
    themeIcon.classList.add('fa-moon');
    themeText.textContent = 'Dark Mode';
  } else {
    themeIcon.classList.remove('fa-moon');
    themeIcon.classList.add('fa-sun');
    themeText.textContent = 'Light Mode';
  }
} else {
  // إذا لم يكن هناك تفضيل مخزن، اضبط الوضع بناءً على تفضيلات النظام
  if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    document.body.setAttribute('data-theme', 'dark');
    themeIcon.classList.remove('fa-sun');
    themeIcon.classList.add('fa-moon');
    themeText.textContent = 'Dark Mode';
  } else {
    document.body.setAttribute('data-theme', 'light');
    themeIcon.classList.remove('fa-moon');
    themeIcon.classList.add('fa-sun');
    themeText.textContent = 'Light Mode';
  }
}
