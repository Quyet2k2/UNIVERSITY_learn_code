package Model_Chuong2_AWT_TKeGUI;

import java.awt.*;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;

public class FrameDemo_NullLayout_1 {

    public static void main(String[] args) {
        // Khai báo và khởi tạo frame có tiêu đề
        Frame myFrame = new Frame("Frame has somes buttons!");
        myFrame.setSize(300, 150); // Định kích cỡ frame
        myFrame.setLayout(null); // Định cách trình bày

        // Button1: vị trí (10,30), kích thước (100,40)
        Button btn1 = new Button("Click1");
        btn1.setSize(100, 40);
        btn1.setLocation(new Point(10, 30));
        myFrame.add(btn1); // Gắn vào frame

        // Button2: vị trí (70,120), kích thước (50,20)
        Button btn2 = new Button("Click2");
        btn2.setBounds(70, 120, 50, 20);
        myFrame.add(btn2); // Gắn vào frame
        myFrame.setVisible(true); // Hiển thị frame

        // Phương thức bắt sự kiện click vào nút đóng frame
        myFrame.addWindowListener(new WindowAdapter() {
            public void windowClosing(WindowEvent e) {
                System.exit(0);
            }
        });
    }

}
