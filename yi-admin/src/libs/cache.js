import Store from "good-storage";
import Cookies from "js-cookie";
// cookie保存的天数
import config from "@/config";

export const TOKEN_KEY = "token";
export const USER_KEY = "__user__";

export const setToken = (token) => {
  Cookies.set(TOKEN_KEY, token, { expires: config.cookieExpires || 1 });
};

export const getToken = () => {
  const token = Cookies.get(TOKEN_KEY);
  if (token) return token;
  else return false;
};

export const localSave = (key, value) => {
  Store.set(key, value);
};

export const localRead = (key) => {
  return Store.get(key) || "";
};

export const saveUserInfo = (userData) => {
  Store.set(USER_KEY, userData);
};

export const loadUserInfo = () => {
  let user = Store.get(USER_KEY);
  if (!user) {
    user = {
      userName: "",
      userId: "",
      avatarImgPath: "",
      token: "",
      access: "",
    };
  }
  return user;
};
