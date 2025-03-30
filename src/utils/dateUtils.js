// dateUtils.js
export function formatDateLinuxStyle(date) {
  const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  
  const dayOfWeek = days[date.getDay()];
  const month = months[date.getMonth()];
  const dayOfMonth = date.getDate();
  
  const hours = date.getHours().toString().padStart(2, '0');
  const minutes = date.getMinutes().toString().padStart(2, '0');
  const seconds = date.getSeconds().toString().padStart(2, '0');
  
  const timeZone = date.toLocaleTimeString('en-US', {timeZoneName: 'short'})
    .split(' ')[2];
  
  const year = date.getFullYear();
  
  return `${dayOfWeek} ${month} ${dayOfMonth} ${hours}:${minutes}:${seconds} ${timeZone} ${year}`;
}