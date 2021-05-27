interface stateInterface {
    sidebar: {
      opened: Boolean,
    },
}

const state = {
    sidebar: {
      opened: true,
    },
}

const mutations = {
    TOGGLE_SIDEBAR: (state: stateInterface): void => {
      state.sidebar.opened = !state.sidebar.opened
    },
    CLOSE_SIDEBAR: (state: stateInterface) => {
      state.sidebar.opened = false
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