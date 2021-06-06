interface sideBarInterface {
    sidebar: {
      rightOpened: Boolean,
      leftOpened: Boolean,
    },
}

const state = {
    sidebar: {
      rightOpened: true,
      leftOpened: true,
    },
}

const mutations = {
    TOGGLE_SIDEBAR: (state: sideBarInterface): void => {
      state.sidebar.leftOpened = !state.sidebar.leftOpened
    },
    CLOSE_SIDEBAR: (state: sideBarInterface) => {
      state.sidebar.leftOpened = false
    }
}

const actions = {
    // @ts-ignore
    toggleSideBar({ commit }) {
      commit('TOGGLE_SIDEBAR')
    },
    // @ts-ignore
    closeSideBar({ commit }) {
      commit('CLOSE_SIDEBAR')
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions
  }