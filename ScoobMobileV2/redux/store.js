// import { configureStore, combineReducers } from "@reduxjs/toolkit";
// import { persistStore, persistReducer } from "redux-persist";
// import AsyncStorage from "@react-native-async-storage/async-storage";

// import childInfoReducer from "./childInfoReducer";

// const rootReducer = combineReducers({
//   childInfo: childInfoReducer,
// });

// const persistConfig = {
//   key: "root",
//   storage: AsyncStorage,
// };

// const persistedReducer = persistReducer(persistConfig, rootReducer);

// const store = configureStore({
//   reducer: persistedReducer,
// });

// const persistor = persistStore(store);

// export { store, persistor };


import { configureStore, combineReducers } from "@reduxjs/toolkit";
import { persistStore, persistReducer } from "redux-persist";
import { FileSystemStorage } from "redux-persist-expo-filesystem"; // Import FileSystemStorage

import childInfoReducer from "./childInfoReducer";

const rootReducer = combineReducers({
  childInfo: childInfoReducer,
});

const persistConfig = {
  key: "root",
  storage: FileSystemStorage, // Use FileSystemStorage for Expo Go
};

const persistedReducer = persistReducer(persistConfig, rootReducer);

const store = configureStore({
  reducer: persistedReducer,
});

const persistor = persistStore(store);

export { store, persistor };


