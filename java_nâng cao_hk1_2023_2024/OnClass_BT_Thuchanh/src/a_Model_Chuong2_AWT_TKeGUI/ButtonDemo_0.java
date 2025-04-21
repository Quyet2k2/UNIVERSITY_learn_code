package Model_Chuong2_AWT_TKeGUI; //// minh hoạ việc tạo một nút nhấn trong một frame.

import java.awt.*;

public class ButtonDemo_0 {

    public static void main(String[] args) {// Khai báo và khởi tạo frame có tiêu đề
        Frame myFrame = new Frame("Frame has a button!");
        myFrame.setSize(300, 150); // Định kích cỡ frame
        
        //Tao 1 button va Them vao Frame
        Button myButton = new Button("Click!"); // Khai báo và khởi tạo button
//        myButton.doLayout();
//        myButton.setSize(5, 5);
        myFrame.add(myButton); // Gắn vào frame
        
        myFrame.setVisible(true); // Hiển thị frame}
    }
}
