import { LOGIN, LOGOUT } from "../action";

const initialState = {
  user: null, // supponiamo che non ci sia nessun utente loggato
};

const mainReducer = (oldlState = initialState, action) => {
  switch (action.type) {
    case LOGIN:
      return {
        ...oldlState,
        user: action.payload,
      };
    case LOGOUT:
      return {
        ...oldlState,
        user: null,
      };
    default:
      return oldlState;
  }
};

export default mainReducer;
