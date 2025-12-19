import { createContext, useState, useEffect, useContext } from "react";
import axios from "axios";

const AuthContext = createContext();

// Configure Axios for cookies
axios.defaults.withCredentials = true;
const API_URL = "http://192.168.18.21:5000/api";

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    checkUser();
  }, []);

  const checkUser = async () => {
    try {
      const { data } = await axios.get(`${API_URL}/auth/me`);
      setUser(data);
    } catch (e) {
      setUser(null);
    } finally {
      setLoading(false);
    }
  };

  const login = async (email, password) => {
    const { data } = await axios.post(`${API_URL}/auth/login`, {
      email,
      password,
    });
    setUser(data.user);
    return data.user;
  };

  const register = async (username, email, password) => {
    // This sends the data to your Node.js server
    await axios.post(`${API_URL}/auth/register`, { username, email, password });
  };

  // --- ADDED THIS FUNCTION ---
  const forgotPassword = async (email) => {
    // This will tell your backend to send a reset link
    await axios.post(`${API_URL}/auth/forgot-password`, { email });
  };

  const logout = async () => {
    await axios.post(`${API_URL}/auth/logout`);
    setUser(null);
  };

  return (
    <AuthContext.Provider
      value={{
        user,
        login,
        register,
        logout,
        forgotPassword,
        loading,
        API_URL,
      }}
    >
      {children}
    </AuthContext.Provider>
  );
};

export const useAuth = () => useContext(AuthContext);
