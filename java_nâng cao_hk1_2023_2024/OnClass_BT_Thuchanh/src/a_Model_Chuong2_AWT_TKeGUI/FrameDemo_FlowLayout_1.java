package Model_Chuong2_AWT_TKeGUI;

import java.awt.*;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;

public class FrameDemo_FlowLayout_1 {

    public static void main(String[] args) { // Khai báo và khởi tạo frame có tiêu đề
        Frame myFrame = new Frame("Frame has somes buttons!");
        myFrame.setSize(300, 150); // Định kích cỡ frame
        myFrame.setLayout(new FlowLayout());// Thiết lập cách trình bày
        // Khai báo và khởi tạo button
        for (int i = 0; i < 10; i++) {
            myFrame.add(new Button("Click" + i));// Gắn vào frame
        }
        myFrame.setVisible(true); // Hiển thị frame
        
        // Phương thức bắt sự kiện click vào nút đóng frame
        myFrame.addWindowListener(new WindowAdapter() {
            public void windowClosing(WindowEvent e) {
                System.exit(0);
            }
        });
    }
}
