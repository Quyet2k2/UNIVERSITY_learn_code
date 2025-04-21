package Chuong2_AWT_TKeGUI;

import java.awt.Button;
import java.awt.Checkbox;
import java.awt.Font;
import java.awt.Frame;
import java.awt.GridLayout;
import java.awt.Label;
import java.awt.TextField;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;

public class Bai_2_GridLayout extends Frame {
//
//    //    Hình 1
//    public Bai_2_GridLayout() {
//        super("Nhập Thông Tin");
//        this.setLayout(new GridBagLayout());
//
//        GridBagConstraints gbc = new GridBagConstraints();
//        gbc.fill = GridBagConstraints.HORIZONTAL;
//        gbc.gridx = 0;
//        gbc.gridy = 0;
//
//        Label label1 = new Label("Họ tên: ");
//        gbc.weightx = 0.2; // Điều chỉnh kích thước của Label
//        this.add(label1, gbc);
//
//        TextField textField1 = new TextField("");
//        gbc.gridx = 1;
//        gbc.weightx = 0.8; // Điều chỉnh kích thước của TextField
//        this.add(textField1, gbc);
//
//        Label label2 = new Label("Email: ");
//        gbc.gridx = 0;
//        gbc.gridy = 1;
//        gbc.weightx = 0.2; // Điều chỉnh kích thước của Label
//        this.add(label2, gbc);
//
//        TextField textField2 = new TextField("");
//        gbc.gridx = 1;
//        gbc.weightx = 0.8; // Điều chỉnh kích thước của TextField
//        this.add(textField2, gbc);
//        
//        this.setSize(300, 150);
//    }

    /**/
//    
////    Hình 2
//    public Bai_2_GridLayout() {
//        super();
//        this.setLayout(new GridLayout(3, 0));
//        
//        this.add(new Label("He so a:"));
//        this.add(new TextField(""));
//        this.add(new Label("He so b:"));
//        this.add(new TextField(""));
//        this.add(new Label("He so c:"));
//        this.add(new TextField(""));
//        
//        this.setSize(300, 120);
//    }
//    
    /**/
//    Hình 3
    Button b1, b2, b3;
    Checkbox c1;
    Label l1, l2;
    TextField t1;

    Button[] buttons = {b1, b2, b3};
    Label[] labels = {l1, l2};

    public Bai_2_GridLayout() {
        super("Grid Dempo");
        this.setLayout(new GridLayout(4, 0, 15, 10));

        b1 = new Button("Red");
        b2 = new Button("Blue");
        b3 = new Button("Green");
        c1 = new Checkbox("Pick me");
        l1 = new Label("Enter name here: ");
        t1 = new TextField("");
        l2 = new Label("Them");

        buttons = new Button[]{b1, b2, b3}; // Tạo và gán giá trị cho mảng buttons
        labels = new Label[]{l1, l2}; // Tạo và gán giá trị cho mảng labels

        // Tạo một font với kích thước ..
        Font customFont = new Font("Arial", Font.PLAIN, 16);
        this.setFont(customFont);

        // Thiết lập font và kích thước font cho Label và Button
        for (Button button : buttons) {
            this.add(button);
        }

        add(c1);
        this.add(l1);
        this.add(t1);
        this.add(l2);

        this.addWindowListener(new WindowAdapter() {
            @Override
            public void windowOpened(WindowEvent e) {
                b3.requestFocusInWindow(); // Đặt focus vào nút mặc định
            }
        });

        this.setSize(600, 350);
    }

    public static void main(String[] args) {
        Bai_2_GridLayout bai_2_GridLayout = new Bai_2_GridLayout();
        bai_2_GridLayout.setVisible(true);
        bai_2_GridLayout.setLocationRelativeTo(null);
        bai_2_GridLayout.addWindowListener(new WindowAdapter() {
            public void windowClosing(WindowEvent e) {
                System.exit(0);
            }
        });
    }
}
