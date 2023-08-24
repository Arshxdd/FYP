// childInfoReducer.js

// Action types
const SUBSCRIBE_CHILD = "SUBSCRIBE_CHILD";
const UNSUBSCRIBE_CHILD = "UNSUBSCRIBE_CHILD";

// Initial state
const initialState = {
  children: [], // An array to store information about multiple children
};

// Reducer
const childInfoReducer = (state = initialState, action) => {
  switch (action.type) {
    case SUBSCRIBE_CHILD:
    case UNSUBSCRIBE_CHILD:
      return {
        ...state,
        children: state.children.map((child) =>
          child.studentid === action.payload.studentid
            ? { ...child, subscriptionStatus: action.payload.subscriptionStatus }
            : child
        ),
      };
    default:
      return state;
  }
};

// Action creators
export const subscribeChild = (studentid) => ({
  type: SUBSCRIBE_CHILD,
  payload: {
    studentid,
    subscriptionStatus: "Yes",
  },
});

export const unsubscribeChild = (studentid) => ({
  type: UNSUBSCRIBE_CHILD,
  payload: {
    studentid,
    subscriptionStatus: "No",
  },
});

export default childInfoReducer;
