/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Chuong2_AWT_TKeGUI;

import java.awt.BorderLayout;
import java.awt.Dimension;
import java.awt.GridLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.ItemEvent;
import java.awt.event.ItemListener;
import java.awt.event.WindowAdapter;
import java.awt.event.WindowEvent;
import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JOptionPane;
import javax.swing.JPanel;
import javax.swing.JTextField;

/**
 *
 * @author quyet
 */
public class Bai_4_UI_va_SKien extends JFrame implements ActionListener, ItemListener {
//
////    Hình 1
//    public Bai_4_UI_va_SKien() {
//        super("Bai tap thuc hanh #2.");
//        this.setLayout(new GridLayout(3, 2));
//        this.setSize(300, 150);
//
//        this.add(new JLabel("User Name: "));
//        this.add(new JTextField("Phạm Văn Quyết: "));
//        this.add(new JLabel("Pass Word: "));
//        this.add(new JPasswordField("12345"));
//        this.add(new JButton("Login"));
//        this.add(new JButton("Cancel"));
//    }

    /* */
// /*Hình 2 */
//    JTextField t1, t2;
//    JButton b1, b2;
//    JLabel l1;
//
//    @Override
//    public void actionPerformed(ActionEvent e) {
//        if (e.getSource() == b1) {
//            try {
//                l1.setText(Integer.toString((int) (Double.parseDouble(t1.getText()) + Double.parseDouble(t2.getText()))));
//            } catch (Exception a) {
//                l1.setText("loi: " + a.getMessage().toString());
//            }
//        }
//
//        if (e.getSource() == b2) {
//            try {
//                l1.setText(Integer.toString((int) (Double.parseDouble(t1.getText()) - Double.parseDouble(t2.getText()))));
//            } catch (Exception a) {
//                l1.setText("loi: " + a.getMessage().toString());
//            }
//        }
//    }
//
//    public Bai_4_UI_va_SKien() {
//        super("Chuong trinh Demo: Tính số nguyên");
//        this.setLayout(new BorderLayout());
//        this.setSize(500, 350);
//        Font font = new Font("Arial", Font.PLAIN, 24);
//        this.setFont(font);
//
//        JPanel panel = new JPanel();
//        panel.setLayout(new GridLayout(4, 2));
//        panel.setPreferredSize(new Dimension(500, 200));
//        this.add(panel, BorderLayout.NORTH);
//
//        t1 = new JTextField("");
//        t2 = new JTextField("");
//        l1 = new JLabel("");
//        b1 = new JButton("Cong");
//        b2 = new JButton("Tru");
//
//        panel.add(new JLabel("Nhap So 1: "));
//        panel.add(t1);
//        panel.add(new JLabel("Nhap So 2: "));
//        panel.add(t2);
//        panel.add(new JLabel("Ket Qua: "));
//        panel.add(l1);
//        panel.add(b1);
//        panel.add(b2);
//
//        b1.addActionListener(this);
//        b2.addActionListener(this);
//    }

    /*  */
 /*Hình 3*/
    JTextField t1, t2;
    JButton b1, b2, b3, b4, b5;
    JLabel l1;
    JButton[] buttons;
    
    @Override
    public void itemStateChanged(ItemEvent e) {
        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
    }

    @Override
    public void actionPerformed(ActionEvent e) {
        try {
            if (e.getSource() == b1) {
                l1.setText(Double.toString(Double.parseDouble(t1.getText()) + (Double.parseDouble(t2.getText()))));
            }
            if (e.getSource() == b2) {
                l1.setText(Double.toString(Double.parseDouble(t1.getText()) - (Double.parseDouble(t2.getText()))));
            }
            if (e.getSource() == b3) {
                l1.setText(Double.toString(Double.parseDouble(t1.getText()) * (Double.parseDouble(t2.getText()))));
            }
            if (e.getSource() == b4) {
                l1.setText(Double.toString(Double.parseDouble(t1.getText()) / (Double.parseDouble(t2.getText()))));
            }
            if (e.getSource() == b5) {
                int choice = JOptionPane.showConfirmDialog(this, "Bạn có muốn thoát chương trình?", "Xác nhận", JOptionPane.YES_NO_OPTION);
                if (choice == JOptionPane.YES_OPTION) {
                    System.exit(0); // Thoát chương trình
                }
            }
        } catch (Exception a) {
            l1.setText(a.getMessage().toString());
        }
    }

    public Bai_4_UI_va_SKien() {
        super("Event demo! Tính toán.");
        this.setSize(400, 250);
        this.setLayout(new BorderLayout());

        JPanel jPanel1 = new JPanel();
        jPanel1.setLayout(new GridLayout(3, 2));
        jPanel1.setPreferredSize(new Dimension(300, 100));
        this.add(jPanel1, BorderLayout.NORTH);

        t1 = new JTextField();
        t2 = new JTextField();
        b1 = new JButton("Cong");
        b2 = new JButton("Tru");
        b3 = new JButton("Nhan");
        b4 = new JButton("Chia");
        b5 = new JButton("Thoat");
        l1 = new JLabel();
        buttons = new JButton[]{b1, b2, b3, b4, b5};

        jPanel1.add(new JLabel("So thu nhat: "));
        jPanel1.add(t1);
        jPanel1.add(new JLabel("So thu hai: "));
        jPanel1.add(t2);
        jPanel1.add(new JLabel());
        jPanel1.add(l1);

        JPanel jPanel2 = new JPanel();
        jPanel2.setLayout(new GridLayout(3, 2));
        this.add(jPanel2, BorderLayout.SOUTH);
        for (JButton button : buttons) {
            jPanel2.add(button);
            button.addActionListener(this);
        }
    }
    /**/
 /*Hình 4*/
//    JTextField t1, t2, t3;
//    JCheckBox c1, c2;
//    JButton b1, b2, b3, b4;
//
//    @Override
//    public void actionPerformed(ActionEvent e) {
//
//    }
//    
//    @Override
//    public void itemStateChanged(ItemEvent e) {
//        throw new UnsupportedOperationException("Not supported yet."); //To change body of generated methods, choose Tools | Templates.
//    }
//
//    public Bai_4_UI_va_SKien() {
//        super("Bai tap thuc hanh 1");
//        this.setLayout(new GridBagLayout());
//        GridBagConstraints gbc = new GridBagConstraints();
//        gbc.gridx = 0;
//        gbc.gridy = 0;
//        this.setSize(450, 250);
//
//        JPanel jPanel1 = new JPanel();
//        jPanel1.setLayout(new GridLayout(5, 2));
//        jPanel1.setPreferredSize(new Dimension(400, 150));
//        this.add(jPanel1, gbc);
//
//        t1 = new JTextField("");
//        t2 = new JTextField("");
//        t3 = new JTextField("");
//        c1 = new JCheckBox("Male");
//        c2 = new JCheckBox("Female");
//        b1 = new JButton("Add");
//        b2 = new JButton("Find");
//        b3 = new JButton("Delete");
//        b4 = new JButton("Update");
//        JButton[] buttons = new JButton[]{b1, b2, b3, b4};
//
//        jPanel1.add(new JLabel("Name: "));
//        jPanel1.add(t1);
//        jPanel1.add(new JLabel("Birth: "));
//        jPanel1.add(t2);
//        jPanel1.add(new JLabel("Address: "));
//        jPanel1.add(t3);
//        jPanel1.add(new JLabel("Sex: "));
//        jPanel1.add(new JLabel());
//        jPanel1.add(c1);
//        jPanel1.add(c2);
//
//        JPanel jPanel2 = new JPanel();
//        jPanel2.setLayout(new FlowLayout());
//        jPanel2.setAlignmentX(CENTER_ALIGNMENT);
//        gbc.gridy = 2;
//        this.add(jPanel2, gbc);
//
//        jPanel2.add(b1);
//        jPanel2.add(b2);
//        jPanel2.add(b3);
//        jPanel2.add(b4);
//
//        c1.addItemListener(this);
//        c2.addItemListener(this);
//        for (JButton button : buttons) {
//            button.addActionListener(this);
//        }
//    }

    public static void main(String[] args) {
        Bai_4_UI_va_SKien bai_4_UI_va_SKien = new Bai_4_UI_va_SKien();
        bai_4_UI_va_SKien.setVisible(true);
        bai_4_UI_va_SKien.setLocationRelativeTo(null);
//        bai_4_UI_va_SKien.pack();

        bai_4_UI_va_SKien.addWindowListener(new WindowAdapter() {
            @Override
            public void windowClosing(WindowEvent e) {
                System.exit(0);
            }
        });
    }

    

    

}
