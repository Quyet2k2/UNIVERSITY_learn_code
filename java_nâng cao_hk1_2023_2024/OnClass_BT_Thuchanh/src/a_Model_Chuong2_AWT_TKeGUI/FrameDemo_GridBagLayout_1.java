package Model_Chuong2_AWT_TKeGUI;

import java.awt.*;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;

public class FrameDemo_GridBagLayout_1 {

    public static void main(String[] args) {
        // Khai báo và khởi tạo frame có tiêu đề
        Frame myFrame = new Frame("Demo GridBag");
        myFrame.setSize(300, 150); // Định kích cỡ frame
        GridBagLayout layout = new GridBagLayout();
        myFrame.setLayout(layout); // Định cách trình bày

        // Khai báo đối tượng ràng buộc
        GridBagConstraints cts = new GridBagConstraints();
        cts.fill = GridBagConstraints.BOTH;

        // Button1: vị trí (1,1), kích thước (1,1)
        Button btn1 = new Button("Click1");
        cts.gridx = 1;
        cts.gridy = 1;
        cts.gridheight = 1;
        cts.gridwidth = 1;
        layout.setConstraints(btn1, cts); // Định ràng buộc
        myFrame.add(btn1); // Gắn vào frame

        // Button2: vị trí (2,2), kích thước (1,1)
        Button btn2 = new Button("Click2");
        cts.gridx = 2;
        cts.gridy = 2;
        cts.gridheight = 1;
        cts.gridwidth = 1;
        layout.setConstraints(btn2, cts); // Định ràng buộc
        myFrame.add(btn2); // Gắn vào frame

//        // Button3: vị trí (3,3), kích thước (1,1)
//        Button btn3 = new Button("Click3");
//        cts.gridx = 3;
//        cts.gridy = 3;
//        cts.gridheight = 1;
//        cts.gridwidth = 1;
//        layout.setConstraints(btn3, cts); // Định ràng buộc
//        myFrame.add(btn3); // Gắn vào frame
        myFrame.setVisible(true); // Hiển thị frame

        // Phương thức bắt sự kiện click vào nút đóng frame
        myFrame.addWindowListener(new WindowAdapter() {
            public void windowClosing(WindowEvent e) {
                System.exit(0);
            }
        });
    }
}
