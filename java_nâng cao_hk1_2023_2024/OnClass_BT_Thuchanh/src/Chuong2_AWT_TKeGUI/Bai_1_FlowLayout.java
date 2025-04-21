/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Chuong2_AWT_TKeGUI;

import java.awt.*;
import java.awt.event.*;

/**
 *
 * @author quyet
 */
public class Bai_1_FlowLayout extends Frame implements ActionListener, ItemListener, TextListener {

    Label l1, l2;
    Button b1, b2, b3;
    List l;
    Checkbox c;
    TextField t;

    public Bai_1_FlowLayout() {
        super("Frame has somes buttons!");
        this.setLayout(new FlowLayout(FlowLayout.LEFT, 10, 20));

        b1 = new Button("Red");
        b2 = new Button("Green");
        b3 = new Button("Blue");
        l = new List();
        l.add("Mot");
        l.add("Hai");
        l.add("Ba");
        c = new Checkbox("Pick me");
        l1 = new Label("Enter your name");
        t = new TextField(20);

        this.add(b1);
        b1.addActionListener(this);
        this.add(b2);
        b2.addActionListener(this);
        this.add(b3);
        b3.addActionListener(this);
        this.add(l);
        l.addItemListener(this);
        this.add(c);
        l.addItemListener(this);
        this.add(l1);
        this.add(t);
        t.addTextListener(this);
        l2 = new Label("Ban da chon:....                ");
        this.add(l2);
        c.addItemListener(this);

    }

    @Override
    public void actionPerformed(ActionEvent e) {
        if (e.getSource() == b1) {
            this.setBackground(Color.RED);
            l2.setText("Ban da chon: " + b1.getLabel());
        }
        if (e.getSource() == b2) {
            this.setBackground(Color.green);
            l2.setText("Ban da chon: " + b1.getLabel());
        }
        if (e.getSource() == b3) {
            this.setBackground(Color.blue);
            l2.setText("Ban da chon: " + b1.getLabel());
        }
    }

    @Override
    public void itemStateChanged(ItemEvent e) {
        if (e.getStateChange() == ItemEvent.SELECTED) {
            String d = (String) l.getSelectedItem();
            l2.setText("Ban da chon: " + d);
        }

        if (e.getSource() == c) {
            if (e.getStateChange() == ItemEvent.SELECTED) {
                l2.setText("Ban da chon Pick Me");
            } else {
                l2.setText("Ban khong chon Pick Me");
            }
        }
    }

    @Override
    public void textValueChanged(TextEvent e) {
        String enteredText = t.getText();
        l2.setText("Ban da nhap: " + enteredText);
    }

    public static void main(String[] args) {
        Bai_1_FlowLayout bai_1_FlowLayout = new Bai_1_FlowLayout();
        bai_1_FlowLayout.setSize(460, 300);
        bai_1_FlowLayout.setVisible(true);

        // Phương thức bắt sự kiện click vào nút đóng frame
        bai_1_FlowLayout.addWindowListener(new WindowAdapter() {
            public void windowClosing(WindowEvent e) {
                System.exit(0);
            }
        });

        // Đặt frame ở giữa màn hình
        bai_1_FlowLayout.setLocationRelativeTo(null);
    }
}
