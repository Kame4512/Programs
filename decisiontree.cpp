 #include <iostream>
 #include <string>
#include "binarytree.h"
using namespace std;

int main() {
/*
The following (partial) decision tree is built
by the code that follows.

                                    0.                 Is human?
                                                  /                                                                                                               \
                                                yes                                                                                                               no
                                                /                                                                                                                   \
                              1.           is a demi-human?                                                                                                         Is a Elemental  ?
                                              /   \                                                                                                                     /                       \
                                            yes    no                                                                                                                  yes                          no
                                            /       \                                                                                                                  /                                \
        2.                   is a beast type?       Lives during the day                                                                            Is a Chaos Spirit?                               Is a animal type?
                            /             \                      /                        \                                                       /               \                                        /          \
                           yes             no                  yes                        no                                                        yes               no                                yes            no                                                     
                          /                 \                  /                            \                                                       /                   \                               /                 \     
            3.       has scales?       has long ears?       Came before a century?      Strong against sun?                                Is a dragon type?                  Is holy based?     Is from earth?     Can speak? 
                    /       \           /         \              /        \                      /            \                                 /      \                      /    \              /   \               /     \  
                  yes      no          yes        no           yes         no                  yes            no                              yes      no                    yes    no           yes    no           yes     no
                /         \            /           \           /            \                   /                \                            /           \                  /         \         /         \         /          \ 
    4.    Dragonewt     Lycanthrope   Elf          Oni     High Human      Regular Huamn    Overcomer Vampire    Regular Vampire          True Dragon    Ultimate Slime     Angel    Demon    Direwolf    Cryptid   Spector     Slime
         
         P.S: My questions are long so it looks wierd.
*/
binaryTreeType<string> race("Is human?");
 
 // root level
 race.add_decision("Is human?", "left", "Is a demi-human?");
 race.add_decision("Is human?","right","Is a Elemental?");
 
 //1st level
 race.add_decision("Is a demi-human?","left", "Is a beast type?");
 race.add_decision("Is a demi-human?","right","Lives during day?");

 race.add_decision("Is a Elemental?","left","Is a Chaos Spirit?");
 race.add_decision("Is a Elemental?","right","Is a animal type?");

//2nd level
 race.add_decision("Is a beast type?","left", "Has scales?");
 race.add_decision("Is a beast type?","right","Has long ears?");

 race.add_decision("Lives during day?","left","Came before a century?");
 race.add_decision("Lives during day?","right","Strong against sun?");

 race.add_decision("Is a Chaos Spirit?","left","Is a dragon type?");
 race.add_decision("Is a Chaos Spirit?","right","Is holy based?");

 race.add_decision("Is a animal type?","left","Is from earth?");
 race.add_decision("Is a animal type?","right","Can speak?");


//3rd level
 race.add_decision("Has scales?","left","Dragonewt");
 race.add_decision("Has scales?","right","Lycanthrope");

 race.add_decision("Has long ears?","left","Elf");
 race.add_decision("Has long ears?","right","Oni");

 race.add_decision("Came before a century?","left","High Human");
 race.add_decision("Came before a century?","right","Regular Human");

 race.add_decision("Strong against sun?","left","Overcomer Vampire");
 race.add_decision("Strong against sun?","right","Regular Vampire");

 race.add_decision("Is a dragon type?","left","True Dragon");
 race.add_decision("Is a dragon type?","right","Ultimate Slime");

 race.add_decision("Is holy based?","left","Angel");
 race.add_decision("Is holy based?","right","Demon");

 race.add_decision("Is from earth?","left","Direwolf");
 race.add_decision("Is from earth?","right","Cryptid");

 race.add_decision("Can speak?","left","Spector");
 race.add_decision("Can speak?","right","Slime");
 

 //animal.preorderTraversal();



 cout << endl;

  string number;

  while(number != "6")
  {
    
  cout << "-----Menu-----\n1. Traversal\n2. Search the Tree\n3. Update a Node\n4. Add a node to the decision tree\n5. Use the tree to find an outcome\n6. Quit" << endl;
  cout << "Enter a number for the option you to use: ";
  cin >> number;

    if(number == "1")
    {
      string order;
      cout << "Select which Traversal you want to preform:";
        cout << "\n1.Preorder\n2.Inorder\n3.Postorder\n4.Quit\nEnter number: ";
        cin >> order;
      if(order == "1" || order == "2" || order == "3")
      {
        
        if(order == "1")
        {
          race.preorderTraversal();
        }
        else if(order == "2")
        {
          race.inorderTraversal();
        }
        else if(order == "3")
        {
          race.postorderTraversal();
        }
        
      }
    }

    if(number =="2")
    {
      string key;
      cout << "Enter node: ";
      getline(cin, key);

      if(getline(cin, key))
      {
        race.searchfornode(key);       
      }
      
    }

    if(number == "3")
    {
      string node1, change;
      cout << "Enter node: ";
      getline(cin, node1);

      if(getline(cin, node1))
      {

        cout << "Enter new node change: ";
        getline(cin, change);

        race.updatenode(node1, change);
      }
      
    }
    
    if(number == "4")
    {
      string pos1 = "left";
      string pos2 = "right";
      
      string parent_node, left_child, right_child;
      cout << "Enter parent node: ";
      getline(cin, parent_node);
      
      if(getline(cin, parent_node))
      {
        cout << "Enter left child: ";       
        getline(cin, left_child);
        
          cout << "Enter right child: ";
          getline(cin, right_child);

            race.add_decision(parent_node, pos1, left_child);
            race.add_decision(parent_node, pos2, right_child);
          
        
      }
    
      
      

      
      
      //if(getline(cin, parent_node) && getline(cin, left_child) && getline(cin, right_child))
      
        
      
      //if(parent_node != parent)
      //race.inorderTraversal();
    }

    if(number == "5")
    {
      race.findoutcome();

    }

    if(number == "6")
    {
      race.destroyTree();
    }
  }
  

}