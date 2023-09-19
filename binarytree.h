//Header File Binary Search Tree
#ifndef H_binaryTree
#define H_binaryTree

#include <iostream>

using namespace std; 
 
    //Definition of the Node
template <class elemType>
struct nodeType
{
    elemType info;
    nodeType<elemType> *lLink;
    nodeType<elemType> *rLink;
};
	
    //Definition of the class
template <class elemType>
class binaryTreeType
{
public:
    const binaryTreeType<elemType>& operator=
                 (const binaryTreeType<elemType>&); 
      //Overload the assignment operator.

    bool isEmpty() const;
      //Function to determine whether the binary tree is empty.
      //Postcondition: Returns true if the binary tree is empty;
      //               otherwise, returns false.

    void inorderTraversal() const;
      //Function to do an inorder traversal of the binary tree.
      //Postcondition: Nodes are printed in inorder sequence.

    void preorderTraversal() const;
      //Function to do a preorder traversal of the binary tree.
      //Postcondition: Nodes are printed in preorder sequence.

    void postorderTraversal() const;
      //Function to do a postorder traversal of the binary tree.
      //Postcondition: Nodes are printed in postorder sequence.

    
    void findoutcome() const;

    void searchfornode(string key) const;

    void updatenode(string key, string change) const;
   

    int treeHeight() const;
      //Function to determine the height of a binary tree.
      //Postcondition: Returns the height of the binary tree.

    int treeNodeCount() const;
      //Function to determine the number of nodes in a 
      //binary tree.
      //Postcondition: Returns the number of nodes in the 
      //               binary tree.

    int treeLeavesCount() const;
      //Function to determine the number of leaves in a 
      //binary tree.
      //Postcondition: Returns the number of leaves in the 
      //               binary tree.

    void destroyTree();
      //Function to destroy the binary tree.
      //Postcondition: Memory space occupied by each node 
      //               is deallocated.
      //               root = nullptr;

    binaryTreeType(const binaryTreeType<elemType>& otherTree); 
      //Copy constructor

    binaryTreeType();   
      //Default constructor

		binaryTreeType(const elemType& item);


    ~binaryTreeType();   
      //Destructor

    void add_decision(const elemType& parent_decision, string position, const elemType& new_decision); 
    void addadecision(nodeType<elemType> *node, const elemType& parent_decision, string position, const elemType& new_decision); 


protected:
    nodeType<elemType>  *root;

private:
    void copyTree(nodeType<elemType>* &copiedTreeRoot,
                  nodeType<elemType>* otherTreeRoot);
      //Makes a copy of the binary tree to which 
      //otherTreeRoot points. 
      //Postcondition: The pointer copiedTreeRoot points to
      //               the root of the copied binary tree.

    void destroy(nodeType<elemType>* &p);
      //Function to destroy the binary tree to which p points.
      //Postcondition: Memory space occupied by each node, in 
      //               the binary tree to which p points, is 
      //               deallocated.
      //               p = nullptr;

    void inorder(nodeType<elemType> *p) const;
      //Function to do an inorder traversal of the binary
      //tree to which p points.  
      //Postcondition: Nodes of the binary tree, to which p
      //               points, are printed in inorder sequence.

    void preorder(nodeType<elemType> *p) const;
      //Function to do a preorder traversal of the binary
      //tree to which p points.  
      //Postcondition: Nodes of the binary tree, to which p
      //               points, are printed in preorder 
      //               sequence.

    void postorder(nodeType<elemType> *p) const;
      //Function to do a postorder traversal of the binary
      //tree to which p points.  
      //Postcondition: Nodes of the binary tree, to which p
      //               points, are printed in postorder 
      //               sequence.

    void outcome(nodeType<elemType> *p) const;
    
    void search(string key, nodeType<elemType> *p) const;

    void update(string key, string change, nodeType<elemType> *p) const;

    int height(nodeType<elemType> *p) const;
      //Function to determine the height of the binary tree
      //to which p points. 
      //Postcondition: Height of the binary tree to which 
      //               p points is returned.

    int max(int x, int y) const;
      //Function to determine the larger of x and y.
      //Postcondition: Returns the larger of x and y.

    int nodeCount(nodeType<elemType> *p) const;
      //Function to determine the number of nodes in 
      //the binary tree to which p points. 
      //Postcondition: The number of nodes in the binary 
      //               tree to which p points is returned.

    int leavesCount(nodeType<elemType> *p) const;
      //Function to determine the number of leaves in  
      //the binary tree to which p points 
      //Postcondition: The number of leaves in the binary 
      //               tree to which p points is returned.


};

	//Definition of member functions

template <class elemType>
binaryTreeType<elemType>::binaryTreeType()
{
    root = nullptr;
}

template <class elemType>
binaryTreeType<elemType>::binaryTreeType(const elemType& item)
{
    root = new nodeType<elemType>;
		root->info = item;
		root->lLink = nullptr;
		root->rLink = nullptr;
}
template <class elemType>
bool binaryTreeType<elemType>::isEmpty() const
{
    return (root == nullptr);
}

template <class elemType>
void binaryTreeType<elemType>::inorderTraversal() const
{
    inorder(root);
}

template <class elemType>
void binaryTreeType<elemType>::preorderTraversal() const
{
    preorder(root);
}

template <class elemType>
void binaryTreeType<elemType>::postorderTraversal() const
{
    postorder(root);
}

template <class elemType>
int binaryTreeType<elemType>::treeHeight() const
{
    return height(root);
}

template <class elemType>
int binaryTreeType<elemType>::treeNodeCount() const
{
    return nodeCount(root);
}

template <class elemType>
int binaryTreeType<elemType>::treeLeavesCount() const
{
    return leavesCount(root);
}

template <class elemType>
void  binaryTreeType<elemType>::copyTree
                       (nodeType<elemType>* &copiedTreeRoot,
                        nodeType<elemType>* otherTreeRoot)
{
    if (otherTreeRoot == nullptr)
        copiedTreeRoot = nullptr;
    else
    {
        copiedTreeRoot = new nodeType<elemType>;
        copiedTreeRoot->info = otherTreeRoot->info;
        copyTree(copiedTreeRoot->lLink, otherTreeRoot->lLink);
        copyTree(copiedTreeRoot->rLink, otherTreeRoot->rLink);
    }
} //end copyTree

template <class elemType>
void binaryTreeType<elemType>::inorder
                              (nodeType<elemType> *p) const
{
    if (p != nullptr)
    {
        inorder(p->lLink);
        cout << p->info << " ";
        inorder(p->rLink);
    }
}

template <class elemType>
void binaryTreeType<elemType>::preorder
                              (nodeType<elemType> *p) const
{
    if (p != nullptr)
    {
        cout << p->info << " ";
        preorder(p->lLink);
        preorder(p->rLink);
    }
}

template <class elemType>
void binaryTreeType<elemType>::postorder
                              (nodeType<elemType> *p) const
{
    if (p != nullptr)
    {
        postorder(p->lLink);
        postorder(p->rLink);
        cout << p->info << " ";
    }		
}



   //Overload the assignment operator
template <class elemType>
const binaryTreeType<elemType>& binaryTreeType<elemType>::
        operator=(const binaryTreeType<elemType>& otherTree)
{ 
    if (this != &otherTree) //avoid self-copy
    {
        if (root != nullptr)   //if the binary tree is not empty,
                            //destroy the binary tree
            destroy(root);

        if (otherTree.root == nullptr) //otherTree is empty
            root = nullptr;
        else
            copyTree(root, otherTree.root);
    }//end else

    return *this; 
}

template <class elemType>
void  binaryTreeType<elemType>::destroy(nodeType<elemType>* &p)
{
    if (p != nullptr)
    {
        destroy(p->lLink);
        destroy(p->rLink);
        delete p;
        p = nullptr;
    }
}

template <class elemType>
void  binaryTreeType<elemType>::destroyTree()
{
    destroy(root);
}

	//copy constructor
template <class elemType>
binaryTreeType<elemType>::binaryTreeType
                (const binaryTreeType<elemType>& otherTree)
{
    if (otherTree.root == nullptr) //otherTree is empty
        root = nullptr;
    else
        copyTree(root, otherTree.root);
}

    //Destructor
template <class elemType>
binaryTreeType<elemType>::~binaryTreeType()
{
    destroy(root);
}

template<class elemType>
int binaryTreeType<elemType>::height
                             (nodeType<elemType> *p) const
{
    if (p == nullptr)
        return 0;
    else
        return 1 + max(height(p->lLink), height(p->rLink));
}

template <class elemType>
int binaryTreeType<elemType>::max(int x, int y) const
{
    if (x >= y)
        return x;
    else
        return y;
}

template <class elemType>
int binaryTreeType<elemType>::nodeCount(nodeType<elemType> *p) const
{
    cout << "Write the definition of the function nodeCount."
         << endl;

    return 0;
}

template <class elemType>
int binaryTreeType<elemType>::leavesCount(nodeType<elemType> *p) const
{
    cout << "Write the definition of the function leavesCount."
         << endl;

    return 0;
}

template <class elemType>
void binaryTreeType<elemType>::addadecision(nodeType<elemType> *node, const elemType& parent_decision, string position, const elemType& new_decision)
{
    if (node == nullptr) {
        return;
    }

    if (node->info == parent_decision) {
        
        nodeType<elemType> *new_node = new nodeType<elemType>;
       
		new_node->info = new_decision;
		new_node->lLink = nullptr;
		new_node->rLink = nullptr;

        if (position == "left") {
            node->lLink = new_node;
        } else if (position == "right")   {
    
            node->rLink = new_node;
        } else {

            delete new_node;
        }

        return;
    }
    addadecision(node->lLink, parent_decision, position, new_decision);
    addadecision(node->rLink, parent_decision, position, new_decision);
}

template <class elemType>
void binaryTreeType<elemType>::add_decision(const elemType& parent_decision, string position, const elemType& new_decision)
{
   addadecision(root,parent_decision, position, new_decision);

}

template <class elemType>
void binaryTreeType<elemType>::update(string key, string change, nodeType<elemType> *p) const
{
    if(p != nullptr)
    {
        update(key, change, p->lLink);
        update(key, change, p->rLink);
        if(p->info == key)
        {
            p->info = change;
        }
    }
}

template <class elemType>
void binaryTreeType<elemType>::updatenode(string key, string change) const
{
    update(key, change, root);
}


template <class elemType>
void binaryTreeType<elemType>::search(string key, nodeType<elemType> *p) const
{
    if(p != nullptr)
    {
        search(key, p->lLink);
        search(key, p->rLink);
        if(p->info == key)
        {
            if(p->lLink != nullptr && p->rLink != nullptr)
            {
                cout  <<"\n" << p->info << " is in the tree with the left child is " <<  p->lLink->info << " and right child is " << p->rLink->info << endl;
            }
            else if(p->lLink == nullptr && p->rLink == nullptr)
            {
                cout << "\n" << p->info << " is in the tree" << endl;
            }

        }
        
    }

}

template <class elemType>
void binaryTreeType<elemType>::searchfornode(string key) const
{
    search(key, root);

}

template <class elemType>
void binaryTreeType<elemType>::findoutcome() const
{
    outcome(root);
}

template <class elemType>
void binaryTreeType<elemType>::outcome(nodeType<elemType> *p) const
{
    string option;
    if(p != nullptr)
    {
        if(p ->lLink == nullptr && p ->rLink == nullptr)
        {
            cout << p ->info << endl;
        }
        
        else if(p ->lLink != nullptr || p ->rLink != nullptr)
        {
            cout << p ->info << endl;
            cout << "Enter yes or no: ";
            cin >> option;

            
        }
        if(option == "yes")
        {
            outcome(p->lLink);
        }
        else if(option == "no")
        {
            outcome(p->rLink);
        }
    }
}

#endif
