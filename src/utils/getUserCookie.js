export default function getUserCookie(name=" user_info"){
  const cookies = document.cookie.split(';' );
  const cookie = cookies.find(c=>c.startsWith(name));
  if(!cookie) return null;
  const value = cookie.split("=")[1];
  const userObject = JSON.parse(decodeURIComponent(value))
  return userObject;
}