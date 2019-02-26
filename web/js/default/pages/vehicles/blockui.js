var BlockUIDemo = {
    init: function () {
        $(".blockable").click(function () {
            mApp.block("#m_blockui_1_content", {
                overlayColor: "#000000",
                type: "loader",
                state: "success",
                message: "Please wait..."
            }), setTimeout(function () {
                mApp.unblock("#m_blockui_1_content")
            }, 2e3)
        })
    }
};
jQuery(document).ready(function () {
    BlockUIDemo.init()
});