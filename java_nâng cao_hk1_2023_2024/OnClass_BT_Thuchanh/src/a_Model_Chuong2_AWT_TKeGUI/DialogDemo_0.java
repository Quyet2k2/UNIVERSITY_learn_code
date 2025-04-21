package Model_Chuong2_AWT_TKeGUI;

import java.awt.*;

public class DialogDemo_0 {

    public static void main(String[] args) {// Khai báo và khởi tạo frame có tiêu đề
        Frame myFrame = new Frame("Frame has a dialog!");
        myFrame.setSize(600, 600); // Định kích cỡ frame
                
        // Khai báo và khởi tạo dialog
        Dialog myDialog = new Dialog(myFrame, "An empty dialog!", true);
        myDialog.setSize(300, 150); // Định kích cỡ dialog
        myDialog.setVisible(true); // Hiển thị dialog}
        
       // myFrame.setVisible(true);
    }
}
